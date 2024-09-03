<?php


namespace MiniRest\Repositories\Produtos;

use MiniRest\Models\Produto\Produto\ProdutosVariasoes;
use MiniRest\Models\Produto\SubProdutos\Estoque;


use MiniRest\Models\Produto\Produto\Produtos;
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




    public function __construct()
    {

        $this->produtos = new Produtos();
        $this->produtosVariasoes = new ProdutosVariasoes();
        $this->subCategorias = new SubCategorias();
        $this->estoque = new Estoque();
        $this->tamanho = new Tamanho();
        $this->categorias = new Categorias();
        $this->cores = new Cores();
    }

    public function getProdutos()
    {

        $produtosAll = $this->produtos->get();
        $produtoCompleto = null;
        foreach ($produtosAll as $produto){
            $categoria = $this->categorias->where('id',$produto->categorias_id)->first();
            $subcategoria = $this->subCategorias->where('id',$produto->subcategorias_id)->first();
            $variacoes = $this->produtosVariasoes->where('produtos_id',$produto->id)->get();
            $variacoesPro = null;
            foreach ($variacoes as $variacao){
                $tamanhoPro = $this->tamanho->where('id',$variacao->tamanho_id)->first();
                $corPro = $this->cores->where('id',$variacao->cores_id)->first();
                $estoquePro = $this->estoque->where('id',$variacao->estoque_id)->first();
                $object = [
                    'id' => $variacao->id,
                    'Valor' => $variacao->Valor,
                    'Status' => $variacao->Status,
                    'Cor' => $corPro->Cor,
                    'Tamanho' => $tamanhoPro->Tamanho,
                    'Estoque' => $estoquePro->Quantidade,

                ];
                $variacoesPro[] = $object;
            }
            $object = [
                'Nome_Produto' => $produto->Nome_Produto,
                'Descricao' => $produto->Descricao,
                'categorias_id' => $produto->categorias_id,
                'categoria' => $categoria->Categoria,
                'subcategorias_id' => $produto->subcategorias_id,
                'subcategorias' => $subcategoria->SubCategoria,
                'variacoesProduto' => $variacoesPro
            ];
            $produtoCompleto[] = $object;
        }


        return $produtoCompleto;



    }


    public function getProdutosCat(int $id)
    {

        $produtosAll = $this->produtos->where('categorias_id',$id)->get();
        $produtoCompleto = null;
        foreach ($produtosAll as $produto){
            $categoria = $this->categorias->where('id',$produto->categorias_id)->first();
            $subcategoria = $this->subCategorias->where('id',$produto->subcategorias_id)->first();
            $variacoes = $this->produtosVariasoes->where('produtos_id',$produto->id)->get();
            $variacoesPro = null;
            foreach ($variacoes as $variacao){
                $tamanhoPro = $this->tamanho->where('id',$variacao->tamanho_id)->first();
                $corPro = $this->cores->where('id',$variacao->cores_id)->first();
                $estoquePro = $this->estoque->where('id',$variacao->estoque_id)->first();
                $object = [
                    'id' => $variacao->id,
                    'Valor' => $variacao->Valor,
                    'Status' => $variacao->Status,
                    'Cor' => $corPro->Cor,
                    'Tamanho' => $tamanhoPro->Tamanho,
                    'Estoque' => $estoquePro->Quantidade,

                ];
                $variacoesPro[] = $object;
            }
            $object = [
                'Nome_Produto' => $produto->Nome_Produto,
                'Descricao' => $produto->Descricao,
                'categorias_id' => $produto->categorias_id,
                'categoria' => $categoria->Categoria,
                'subcategorias_id' => $produto->subcategorias_id,
                'subcategorias' => $subcategoria->SubCategoria,
                'variacoesProduto' => $variacoesPro
            ];
            $produtoCompleto[] = $object;
        }


        return $produtoCompleto;



    }

    public function getProdutosSubCat(int $id)
    {

        $produtosAll = $this->produtos->where('subcategorias_id',$id)->get();

        $produtoCompleto = null;
        foreach ($produtosAll as $produto){
            $categoria = $this->categorias->where('id',$produto->categorias_id)->first();
            $subcategoria = $this->subCategorias->where('id',$produto->subcategorias_id)->first();
            $variacoes = $this->produtosVariasoes->where('produtos_id',$produto->id)->get();
            $variacoesPro = null;
            foreach ($variacoes as $variacao){
                $tamanhoPro = $this->tamanho->where('id',$variacao->tamanho_id)->first();
                $corPro = $this->cores->where('id',$variacao->cores_id)->first();
                $estoquePro = $this->estoque->where('id',$variacao->estoque_id)->first();
                $object = [
                    'id' => $variacao->id,
                    'Valor' => $variacao->Valor,
                    'Status' => $variacao->Status,
                    'Cor' => $corPro->Cor,
                    'Tamanho' => $tamanhoPro->Tamanho,
                    'Estoque' => $estoquePro->Quantidade,

                ];
                $variacoesPro[] = $object;
            }
            $object = [
                'Nome_Produto' => $produto->Nome_Produto,
                'Descricao' => $produto->Descricao,
                'categorias_id' => $produto->categorias_id,
                'categoria' => $categoria->Categoria,
                'subcategorias_id' => $produto->subcategorias_id,
                'subcategorias' => $subcategoria->SubCategoria,
                'variacoesProduto' => $variacoesPro
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