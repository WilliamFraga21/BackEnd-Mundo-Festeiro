<?php


namespace MiniRest\Repositories\Produtos;

use MiniRest\Models\Produto\Produto\Produtos;

class ProdutosRepository
{
    private Produtos $produtos;

    public function __construct()
    {
        $this->produtos = new Produtos();
    }

    public function storeProdutos(array $data)
    {
//        dd($data['Nome_Produto']);

        $id = $this->produtos
            ->updateOrCreate(
                [
                    'Nome_Produto' => $data['Nome_Produto']
                ],
                [
                    'Nome_Produto' => $data['Nome_Produto'],
                    'Descricao' => $data['Descricao'],
                    'categorias_id' => $data['categorias_id'],
                    'subcategorias_id' => $data['subcategorias_id'],
                ]
            );

        return $id->id;

    }

    public function updateProdutos(array $data)
    {
//        dd($data['Nome_Produto']);

        $id = $this->produtos->where('id',$data['ProdutoID'])
            ->update(

                [
                    'Nome_Produto' => $data['Nome_Produto'],
                    'Descricao' => $data['Descricao'],
                    'subcategorias_id' => $data['subcategorias_id'],
                ]
            );

        return $id;

    }
    public function StatusProdutos(array $data)
    {

        return $this->produtos->where('id',$data['id'])->update(
            [
                'Status' => $data['Status']
            ]
        );

    }

    public function getProdutosALL()
    {
        return $this->produtos->get();
    }
    public function getProdutosCat($id)
    {
        return $this->produtos->where('categorias_id',$id)->get();
    }
    public function getProdutosSubCat($id)
    {
        return $this->produtos->where('subcategorias_id',$id)->get();
    }
}