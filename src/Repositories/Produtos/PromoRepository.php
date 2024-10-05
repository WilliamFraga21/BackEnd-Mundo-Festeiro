<?php


namespace MiniRest\Repositories\Produtos;

use MiniRest\Models\Produto\Produto\ProdutosVariasoes;
use MiniRest\Models\Promo;
use MiniRest\Models\Produto\SubProdutos\Estoque;


use MiniRest\Models\Produto\Produto\Produtos;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;
use MiniRest\Models\Produto\SubProdutos\Tamanho;
use MiniRest\Models\Produto\SubProdutos\Categorias;
use MiniRest\Models\Produto\SubProdutos\Cores;
class PromoRepository
{
    private Promo $promo;
    private ProdutosVariasoes $produtosVariasoes;
    private Produtos $produtos;
    private SubCategorias $subCategorias;
    private Estoque $estoque;
    private Tamanho $tamanho;
    private Categorias $categorias;
    private Cores $cores;




    public function __construct()
    {

        $this->promo = new Promo();
        $this->produtos = new Produtos();
        $this->produtosVariasoes = new ProdutosVariasoes();
        $this->subCategorias = new SubCategorias();
        $this->estoque = new Estoque();
        $this->tamanho = new Tamanho();
        $this->categorias = new Categorias();
        $this->cores = new Cores();
    }






    public function storePromo(array $data)
    {


        $idpromo = $this->promo->create(
            [
                'Porcentagem' => $data['Porcentagem'],
                'Tempo' => $data['Tempo']
            ]
        );

        return $idpromo->id;
    }
    public function updatePromoDesativar(int $id)
    {



        $idpromo = $this->produtosVariasoes->where('id',$id)->update(['promo_id'=>null]);

        return $idpromo;



    }
    public function addPromoProduto(array $data)
    {



        $idpromo = $this->produtosVariasoes->where('id',$data['id'])->update(['promo_id'=>$data['idpromo']]);

        return $idpromo;


    }



}