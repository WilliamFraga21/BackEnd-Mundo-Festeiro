<?php


namespace MiniRest\Repositories\Produtos;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\Models\Produto\Produto\ProdutosVariasoes;
use MiniRest\Models\Produto\SubProdutos\Estoque;


use MiniRest\Models\Produto\Produto\Produtos;
use MiniRest\Models\Promo;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;
use MiniRest\Models\Produto\SubProdutos\Tamanho;
use MiniRest\Models\Produto\SubProdutos\Categorias;
use MiniRest\Models\Produto\SubProdutos\Cores;
class ProdutosVariacoesRepository
{
    private ProdutosVariasoes $produtosVariasoes;
    private Produtos $produtos;
    private SubCategorias $subCategorias;
    private Estoque $estoque;
    private Tamanho $tamanho;
    private Categorias $categorias;
    private Cores $cores;
    private Promo $promo;




    public function __construct()
    {

        $this->produtos = new Produtos();
        $this->produtosVariasoes = new ProdutosVariasoes();
        $this->subCategorias = new SubCategorias();
        $this->estoque = new Estoque();
        $this->tamanho = new Tamanho();
        $this->categorias = new Categorias();
        $this->cores = new Cores();
        $this->promo = new Promo();
    }

    public function getProdutos()
    {



        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
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
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Nome_Produto',
                'Descricao',
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->get();


        foreach ($informacoes as $data){


            $object = [
                'Nome_Produto' => $data->Nome_Produto,
                'ProdutoID' => $data->produtosID,
                'Descricao' => $data->Descricao,
                'categorias_id' => $data->categoriasID,
                'subcategorias_id' => $data->subcategoriasID,
                'StatusProduto' => $data->produtosStatus,
                'idVariacao' => $data->produtosvariasoesID,
                'Valor' => $data->Valor,
                'StatusVariacao' => $data->produtosvariasoesStatus,
                'Cor' => $data->Cor,
                'Tamanho' => $data->Tamanho,
                'Estoque' => $data->estoqueQuantidade,
                'StatusProdutoVariacao' => $data->produtosvariasoesStatus,


            ];
            $produtoCompleto[] = $object;

        }




        return $produtoCompleto;



    }




    public function getProdutosPromo($id)
    {








        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
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
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Nome_Produto',
                'Descricao',
                'Porcentagem',
                'Tempo',
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->join('promo', 'produtosvariasoes.promo_id', '=', 'promo.id')
            ->where('produtosvariasoes.promo_id',$id)
            ->get();

        if ($informacoes->isEmpty()){
            return 'Nenhum Produto com Promoção';
        }else{

            foreach ($informacoes as $data){


                $object = [
                    'Nome_Produto' => $data->Nome_Produto,
                    'ProdutoID' => $data->produtosID,
                    'Descricao' => $data->Descricao,
                    'categorias_id' => $data->categoriasID,
                    'subcategorias_id' => $data->subcategoriasID,
                    'StatusProduto' => $data->produtosStatus,
                    'idVariacao' => $data->produtosvariasoesID,
                    'Valor' => $data->Valor,
                    'StatusVariacao' => $data->produtosvariasoesStatus,
                    'Cor' => $data->Cor,
                    'Tamanho' => $data->Tamanho,
                    'Estoque' => $data->estoqueQuantidade,
                    'Porcentagem' => $data->Porcentagem,
                    'Tempo' => $data->Tempo,
                    'valorComDesconto' => ($data->Valor*$data->Porcentagem)/100,
                    'StatusProdutoVariacao' => $data->produtosvariasoesStatus,






                ];
                $produtoCompleto[] = $object;

            }




            return $produtoCompleto;
        }




    }





    public function getProdutosCat(int $id)
    {

        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
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
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Nome_Produto',
                'Descricao',
                'Porcentagem',
                'Tempo',
                'promo.id as idPromo',
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->leftJoin('promo', 'produtosvariasoes.promo_id', '=', 'promo.id')
            ->where('categorias.id',$id)
            ->get();

        foreach ($informacoes as $data){


            $object = [
                'Nome_Produto' => $data->Nome_Produto,
                'ProdutoID' => $data->produtosID,
                'Descricao' => $data->Descricao,
                'categorias_id' => $data->categoriasID,
                'subcategorias_id' => $data->subcategoriasID,
                'StatusProduto' => $data->produtosStatus,
                'idVariacao' => $data->produtosvariasoesID,
                'Valor' => $data->Valor,
                'StatusVariacao' => $data->produtosvariasoesStatus,
                'Cor' => $data->Cor,
                'Tamanho' => $data->Tamanho,
                'Estoque' => $data->estoqueQuantidade,
                'StatusProdutoVariacao' => $data->produtosvariasoesStatus,
                'Porcentagem' => $data->Porcentagem,
                'Tempo' => $data->Tempo,
                'idPromo' => $data->idPromo,


            ];
            $produtoCompleto[] = $object;

        }



        return $produtoCompleto;



    }

    public function getProdutosSubCat(int $id)
    {

        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
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
                'cores_id',
                'tamanho_id',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Nome_Produto',
                'Descricao',
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->where('subcategorias.id',$id)
            ->get();


        foreach ($informacoes as $data){


            $object = [
                'Nome_Produto' => $data->Nome_Produto,
                'ProdutoID' => $data->produtosID,
                'Descricao' => $data->Descricao,
                'categorias_id' => $data->categoriasID,
                'subcategorias_id' => $data->subcategoriasID,
                'StatusProduto' => $data->produtosStatus,
                'idVariacao' => $data->produtosvariasoesID,
                'Valor' => $data->Valor,
                'StatusVariacao' => $data->produtosvariasoesStatus,
                'Cor' => $data->Cor,
                'Tamanho' => $data->Tamanho,
                'Estoque' => $data->estoqueQuantidade,
                'StatusProdutoVariacao' => $data->produtosvariasoesStatus,


            ];
            $produtoCompleto[] = $object;

        }



        return $produtoCompleto;



    }

    public function storeProdutosVari(array $data)
    {


            $idEstoque = $this->estoque->create(
                [
                    'Quantidade' => $data['QuantidadeEstoque']
                ]
            );

            $id = $this->produtosVariasoes
                ->create(

                    [
                        'Valor' => $data['Valor'],
                        'cores_id' => $data['cores_id'],
                        'tamanho_id' => $data['tamanho_id'],
                        'produtos_id' => $data['produtos_id'],
                        'estoque_id' => $idEstoque->id,
                    ]
                );


            return $id->id;



    }
    public function updateProdutosVari(array $data)
    {


        $idEstoque = $this->estoque->where('id',$data['estoque_id'])->update(
            [
                'Quantidade' => $data['QuantidadeEstoque']
            ]
        );

        $quantidadeEstoque = $this->estoque->where('id',$idEstoque)->select('Quantidade')->first();

        if ($quantidadeEstoque->Quantidade < 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $id = $this->produtosVariasoes
            ->where('produtos_id',$data['produtos_id'])->update(

                [
                    'Valor' => $data['Valor'],
                    'Status' => $status,
                ]
            );

        return $id;



    }
    public function statusProdutosVari(array $data)
    {

        return $this->produtosVariasoes->where('id',$data['id'])->update(
            [
                'Status' => $data['Status']
            ]
        );

    }

    public function getProdutosVariALL()
    {
        return $this->produtosVariasoes->get();
    }

}