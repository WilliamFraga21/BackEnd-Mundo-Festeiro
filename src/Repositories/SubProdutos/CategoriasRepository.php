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
        $data = $this->categorias->select(
            'categorias.id as idCategoria',
            'categorias.Categoria',
            'subcategorias.id as idSubCategoria',
            'subcategorias.SubCategoria'
        )
            ->leftJoin('subcategorias', 'categorias.id', '=', 'subcategorias.categorias_id')
            ->get();

// Inicializa um array para armazenar as categorias com suas subcategorias
        $categoriasComSubcategorias = [];

// Loop pelos resultados e organiza os dados
        foreach ($data as $item) {
            // Verifica se a categoria já existe no array
            if (!isset($categoriasComSubcategorias[$item->idCategoria])) {
                // Se não existir, cria uma nova entrada para a categoria
                $categoriasComSubcategorias[$item->idCategoria] = [
                    'idCategoria' => $item->idCategoria,
                    'Categoria' => $item->Categoria,
                    'Subcategorias' => []
                ];
            }

            // Adiciona a subcategoria, se existir
            if ($item->idSubCategoria) {
                $categoriasComSubcategorias[$item->idCategoria]['Subcategorias'][] = [
                    'idSubCategoria' => $item->idSubCategoria,
                    'SubCategoria' => $item->SubCategoria
                ];
            }
        }

// Converte o array associativo em um array indexado
        $resultadoFinal = array_values($categoriasComSubcategorias);

// Retorna ou processa o resultado final
        return $resultadoFinal;



    }
}