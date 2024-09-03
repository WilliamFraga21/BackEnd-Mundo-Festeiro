<?php


namespace MiniRest\Repositories\SubProdutos;

use MiniRest\Models\Produto\SubProdutos\SubCategorias;

class SubCategoriasRepository
{
    private SubCategorias $subCategorias;

    public function __construct()
    {
        $this->subCategorias = new SubCategorias();
    }

    public function storeCategoria(array $data)
    {
        $id = $this->subCategorias
            ->updateOrCreate(
                [
                    'SubCategoria' => $data['SubCategoria'],
                    'categorias_id' => $data['categorias_id'],
                ]
            );


        return $id->id;

    }



    public function getCategoria()
    {
        return $this->subCategorias->select('id','SubCategoria','categorias_id')->get();
    }
}