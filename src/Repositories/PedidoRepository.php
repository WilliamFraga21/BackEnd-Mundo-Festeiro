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


}