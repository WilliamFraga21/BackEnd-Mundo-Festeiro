<?php


namespace MiniRest\Repositories;

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
class ItensCarrinhoRepository
{
    private ItensCarrinho $itensCarrinho;
    private Carrinho $carrinho;

    private ProdutosVariasoes $produtosVariasoes;
    private Produtos $produtos;
    private SubCategorias $subCategorias;
    private Estoque $estoque;
    private Tamanho $tamanho;
    private Categorias $categorias;
    private Cores $cores;


    public function __construct()
    {
        $this->itensCarrinho = new ItensCarrinho();
        $this->carrinho = new Carrinho();

        $this->produtos = new Produtos();
        $this->produtosVariasoes = new ProdutosVariasoes();
        $this->subCategorias = new SubCategorias();
        $this->estoque = new Estoque();
        $this->tamanho = new Tamanho();
        $this->categorias = new Categorias();
        $this->cores = new Cores();
    }

    public function store(array $data,int $idUser)
    {

        $idCarrinho = $this->carrinho->where('users_id',$idUser)->first();
//        dd($idCarrinho->id);
        $id = $this->itensCarrinho
            ->firstOrCreate(
                [
                    'Valor_Uni' => $data['Valor_Uni'],
                    'Quantidade' => $data['Quantidade'],
                    'carrinho_id' => $idCarrinho->id,
                    'carrinho_users_id' => $idUser,
                    'produtosvariasoes_id' => $data['produtosvariasoes_id'],
                ],
                [
                    'Valor_Uni' => $data['Valor_Uni'],
                    'Quantidade' => $data['Quantidade'],
                    'carrinho_id' => $idCarrinho->id,
                    'carrinho_users_id' => $idUser,
                    'produtosvariasoes_id' => $data['produtosvariasoes_id'],
                ]
            );

        return $id->id;

    }

    public function dellid(int $id,int $user)
    {

        $itemDeletado =  $this->itensCarrinho->where('id',$id)->delete();

        return $itemDeletado;
    }

    public function DiminuirQuantidade(int $id,int $user)
    {

        $itemDeletado = $this->itensCarrinho
            ->where('id', $id)
            ->decrement('Quantidade', 1);


        return $itemDeletado;
    }

    public function aumentarQuantidade(int $id,int $user)
    {

        $itemDeletado = $this->itensCarrinho
            ->where('id', $id)
            ->increment('Quantidade', 1);


        return $itemDeletado;
    }
    public function get(int $user)
    {
        $idCarrinho = $this->carrinho->where('users_id',$user)->first();
        $itensCarrinho =  $this->itensCarrinho->where('carrinho_id',$idCarrinho->id)->get();
        $produtoCompleto = null;

        foreach ($itensCarrinho as $data){

            $informacoes = DB::table('produtosvariasoes')
                ->select(
                    'tamanho.id as tamanhoID',
                    'estoque.id as estoqueID',
                    'cores.id as coresID',
                    'subcategorias.id as subcategoriasID',
                    'categorias.id as categoriasID',
                    'produtos.id as produtosID',
                    'produtosvariasoes.id as produtosvariasoesID',
                    'itenscarrinho.id as itenscarrinhoID',
                    'Tamanho',
                    'estoque.Quantidade as estoqueQuantidade',
                    'Cor',
                    'Codigo_Cor',
                    'Categoria',
                    'SubCategoria',
                    'subcategorias.categorias_id as subcategoriasID',
                    'cores_id',
                    'tamanho_id',
                    'Valor',
                    'produtos_id',
                    'estoque_id',
                    'produtosvariasoes.Status as produtosvariasoesStatus',
                    'produtos.Status as produtosStatus',
                    'Valor_Uni',
                    'itenscarrinho.Quantidade as itenscarrinhoQuantidade',
                    'carrinho_users_id',
                    'Nome_Produto',
                    'Descricao',
                )
                ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
                ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
                ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
                ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
                ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
                ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
                ->join('itenscarrinho', 'itenscarrinho.produtosvariasoes_id', '=', 'produtosvariasoes.id') // Adiciona o JOIN correto para a tabela 'itenscarrinho'
                ->where('produtosvariasoes.id', $data->produtosvariasoes_id)
                ->first();

            $object = [
                'Nome_Produto' => $informacoes->Nome_Produto,
                'ProdutoID' => $informacoes->produtosID,
                'Descricao' => $informacoes->Descricao,
                'categorias_id' => $informacoes->categoriasID,
                'categoria' => $informacoes->Categoria,
                'subcategorias_id' => $informacoes->subcategoriasID,
                'subcategorias' => $informacoes->SubCategoria,
                'StatusProduto' => $informacoes->produtosStatus,
                'idItemCarrinho' => $informacoes->itenscarrinhoID,
                'idVariacao' => $informacoes->produtosvariasoesID,
                'Valor' => $informacoes->Valor,
                'StatusVariacao' => $informacoes->produtosvariasoesStatus,
                'Cor' => $informacoes->Cor,
                'Tamanho' => $informacoes->Tamanho,
                'Estoque' => $informacoes->estoqueQuantidade,
                'StatusProdutoVariacao' => $informacoes->produtosvariasoesStatus,
                'QuantidadeItemCarrinho' => $informacoes->itenscarrinhoQuantidade,
                'Valor_Uni' => $informacoes->Valor_Uni,


            ];
            $produtoCompleto[] = $object;


        }
        return $produtoCompleto;
    }


}