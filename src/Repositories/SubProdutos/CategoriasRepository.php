<?php


namespace MiniRest\Repositories\SubProdutos;

use MiniRest\Models\Produto\SubProdutos\Categorias;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;

class CategoriasRepository
{
    private Categorias $categorias;
    private SubCategorias $subCategorias;

    public function __construct()
    {
        $this->categorias = new Categorias();
        $this->subCategorias = new SubCategorias();
    }

    public function storeCategoria(array $data)
    {
        $id = $this->categorias
            ->firstOrCreate(
                [
                    'Categoria' => $data['Categoria'],
                ],
                [
                    'Categoria' => $data['Categoria'],
                ]
            );


        return $id->id;

    }



    public function getCategoria()
    {
        return $this->categorias->select(
            'categorias.id as idCategoria',
            'categorias.Categoria',
            'subcategorias.id as idSubCategoria',
            'subcategorias.SubCategoria'
        )
            ->leftJoin('subcategorias', 'categorias.id', '=', 'subcategorias.categorias_id')
            ->get();
    }
}