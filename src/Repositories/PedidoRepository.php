<?php


namespace MiniRest\Repositories;

use MiniRest\Models\Pedido\Pedido;
use MiniRest\Models\Pedido\ItensPedido;
use MiniRest\Models\Carrinho\ItensCarrinho;
use MiniRest\Models\Carrinho\Carrinho;
use MiniRest\Models\Produto\Produto\Produtos;
use MiniRest\Models\Produto\Produto\ProdutosVariasoes;
use MiniRest\Models\Produto\SubProdutos\Categorias;
use MiniRest\Models\Produto\SubProdutos\Cores;
use MiniRest\Models\Produto\SubProdutos\Estoque;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;
use MiniRest\Models\Produto\SubProdutos\Tamanho;
use Illuminate\Database\Capsule\Manager as DB;
class PedidoRepository
{
    private Pedido $pedido;
    private ItensPedido $itensPedido;
    private ItensCarrinho $itensCarrinho;
    private Carrinho $carrinho;




    public function __construct()
    {

        $this->pedido = new Pedido();
        $this->itensPedido = new ItensPedido();
        $this->itensCarrinho = new ItensCarrinho();
        $this->carrinho = new Carrinho();


    }

    public function store(int $idUser)
    {

        $itensDoCarrinho = $this->itensCarrinho->where('carrinho_users_id',$idUser)->get();





        $valorTotal = null;
        foreach ($itensDoCarrinho as $data){
            $valorTotal += ($data->Quantidade * $data->Valor_Uni);
        }


        $id = $this->pedido
            ->firstOrCreate(
                [
                    'Status' => 'Aguardando Pagamento',
                    'Valor_Total' => $valorTotal,
                    'users_id' => $idUser,
                ],
                [
                    'Status' => 'Aguardando Pagamento',
                    'Valor_Total' => $valorTotal,
                    'users_id' => $idUser,
                ]
            );


        foreach ($itensDoCarrinho as $data){

            $pedidosCadastrados = $this->itensPedido->firstOrCreate([
                'Quantidade' => $data->Quantidade,
                'Valor_Uni' => $data->Valor_Uni,
                'pedido_id' => $id->id,
                'pedido_users_id' => $idUser,
                'produtosvariasoes_id' => $data->produtosvariasoes_id,
        ]);
        }

        foreach ($itensDoCarrinho as $data){
            $itensDoCarrinho = $this->itensCarrinho->where('carrinho_id',$data->carrinho_id)->where('carrinho_users_id',$idUser)->delete();
        }



        return $id->id;

    }





    public function get(int $user)
    {


        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
                'pedido.id as PedidoID',
                'pedido.Status as PedidoStatus',
                'pedido.Valor_Total as PedidoValor_Total',
                'pedido.created_at as PedidoData',
                'itenspedido.id as itenspedidoID',
                'itenspedido.Quantidade as itenspedidoQuantidade',
                'itenspedido.Valor_Uni as itenspedidoValor_Uni',
                'estoque.id as estoqueID',
                'cores.id as coresID',
                'subcategorias.id as subcategoriasID',
                'categorias.id as categoriasID',
                'produtos.id as produtosID',
                'produtosvariasoes.id as produtosvariasoesID',
                'Tamanho',
                'estoque.Quantidade as estoqueQuantidade',
                'Cor',
                'Codigo_Cor',
                'Categoria',
                'SubCategoria',
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Valor_Uni',
                'Nome_Produto',
                'Descricao'
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->join('itenspedido', 'itenspedido.produtosvariasoes_id', '=', 'produtosvariasoes.id')
            ->join('pedido', 'itenspedido.pedido_id', '=', 'pedido.id')
            ->where('users_id', $user)
            ->get();

// Organiza os resultados agrupados por PedidoID
        $pedidosAgrupados = [];

        foreach ($informacoes as $item) {
            $pedidoID = $item->PedidoID;

            // Se o pedido ainda não existir no array, inicializa
            if (!isset($pedidosAgrupados[$pedidoID])) {
                $pedidosAgrupados[$pedidoID] = [
                    'PedidoID' => $item->PedidoID,
                    'PedidoStatus' => $item->PedidoStatus,
                    'PedidoValor_Total' => $item->PedidoValor_Total,
                    'PedidoData' => $item->PedidoData,
                    'Itens' => []
                ];
            }



            // Adiciona os detalhes do item no array 'Itens'
            $pedidosAgrupados[$pedidoID]['Itens'][] = [
                'tamanhoID' => $item->tamanhoID,
                'Tamanho' => $item->Tamanho,
                'estoqueID' => $item->estoqueID,
                'estoqueQuantidade' => $item->estoqueQuantidade,
                'coresID' => $item->coresID,
                'Cor' => $item->Cor,
                'Codigo_Cor' => $item->Codigo_Cor,
                'Valor' => $item->Valor,
                'itenspedidoID' => $item->itenspedidoID,
                'itenspedidoQuantidade' => $item->itenspedidoQuantidade,
                'itenspedidoValor_Uni' => $item->itenspedidoValor_Uni,
                'Nome_Produto' => $item->Nome_Produto,
                'Descricao' => $item->Descricao
            ];
        }


        $pedidosAgrupadosSemChaves = array_values($pedidosAgrupados);


//        }
        return $pedidosAgrupadosSemChaves;
    }







    public function getadmin()
    {


        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
                'pedido.id as PedidoID',
                'pedido.Status as PedidoStatus',
                'pedido.Valor_Total as PedidoValor_Total',
                'pedido.created_at as PedidoData',
                'itenspedido.id as itenspedidoID',
                'itenspedido.Quantidade as itenspedidoQuantidade',
                'itenspedido.Valor_Uni as itenspedidoValor_Uni',
                'estoque.id as estoqueID',
                'users.id as usersID',
                'users.name as name',
                'users.email as email',
                'users.contactno as contactno',
                'cores.id as coresID',
                'subcategorias.id as subcategoriasID',
                'categorias.id as categoriasID',
                'produtos.id as produtosID',
                'produtosvariasoes.id as produtosvariasoesID',
                'Tamanho',
                'estoque.Quantidade as estoqueQuantidade',
                'Cor',
                'Codigo_Cor',
                'Categoria',
                'SubCategoria',
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Valor_Uni',
                'Nome_Produto',
                'Descricao'
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->join('itenspedido', 'itenspedido.produtosvariasoes_id', '=', 'produtosvariasoes.id')
            ->join('pedido', 'itenspedido.pedido_id', '=', 'pedido.id')
            ->join('users', 'pedido.users_id', '=', 'users.id')
            ->get();

// Organiza os resultados agrupados por PedidoID
        $pedidosAgrupados = [];




        function formatarDataAmigavel($dataEntrada)
        {
            // Cria um objeto DateTime com a data fornecida, usando o namespace global
            $data = new \DateTime($dataEntrada);
//                    dd($data);
            $dataAtual = new \DateTime(); // Cria um objeto DateTime para a data atual

            // Calcula a diferença entre a data atual e a data fornecida
            $diferenca = $dataAtual->diff($data);

            // Verifica a diferença em dias, meses e anos
            $dias = $diferenca->days;
            $meses = $diferenca->m;
            $anos = $diferenca->y;

            // Determina a expressão amigável da data
            if ($diferenca->invert == 0) {
                return "no futuro";
            } elseif ($dias == 0) {
                return "hoje";
            } elseif ($dias == 1) {
                return "ontem";
            } elseif ($dias < 7) {
                return "há $dias dias";
            } elseif ($dias < 30) {
                $semanas = floor($dias / 7);
                return "há $semanas " . ($semanas == 1 ? "semana" : "semanas");
            } elseif ($anos == 0) {
                $diasRestantes = $dias - ($meses * 30);
                return "há $meses " . ($meses == 1 ? "mês" : "meses") . ($diasRestantes > 0 ? " e $diasRestantes dias" : "");
            } else {
                $mesesTotais = $meses + ($anos * 12);
                $mesesRestantes = $mesesTotais % 12;
                return "há $anos " . ($anos == 1 ? "ano" : "anos") . ($mesesRestantes > 0 ? " e $mesesRestantes meses" : "");
            }
        }

        foreach ($informacoes as $item) {
            $pedidoID = $item->PedidoID;

            // Se o pedido ainda não existir no array, inicializa
            if (!isset($pedidosAgrupados[$pedidoID])) {






                $pedidosAgrupados[$pedidoID] = [
                    'usersID' => $item->usersID,
                    'contactno' => $item->contactno,
                    'email' => $item->email,
                    'name' => $item->name,
                    'PedidoID' => $item->PedidoID,
                    'PedidoStatus' => $item->PedidoStatus,
                    'PedidoValor_Total' => $item->PedidoValor_Total,
                    'PedidoData' => $item->PedidoData,
                    'TempoPedido' => formatarDataAmigavel($item->PedidoData),
                    'Itens' => []
                ];
            }



            // Adiciona os detalhes do item no array 'Itens'
            $pedidosAgrupados[$pedidoID]['Itens'][] = [
                'tamanhoID' => $item->tamanhoID,
                'Tamanho' => $item->Tamanho,
                'estoqueID' => $item->estoqueID,
                'estoqueQuantidade' => $item->estoqueQuantidade,
                'coresID' => $item->coresID,
                'Cor' => $item->Cor,
                'Codigo_Cor' => $item->Codigo_Cor,
                'Valor' => $item->Valor,
                'itenspedidoID' => $item->itenspedidoID,
                'itenspedidoQuantidade' => $item->itenspedidoQuantidade,
                'itenspedidoValor_Uni' => $item->itenspedidoValor_Uni,
                'Nome_Produto' => $item->Nome_Produto,
                'Descricao' => $item->Descricao
            ];
        }


        $pedidosAgrupadosSemChaves = array_values($pedidosAgrupados);


//        }
        return $pedidosAgrupadosSemChaves;
    }

}