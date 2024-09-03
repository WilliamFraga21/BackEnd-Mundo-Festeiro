<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\CategoriasDTO;
use MiniRest\Repositories\SubProdutos\CategoriasRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class CategoriaCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(CategoriasDTO $categoriaCreateDTO)
    {
        $categoriaData = $categoriaCreateDTO->toArray();


        try {

            $categoriaId = (new CategoriasRepository())->storeCategoria($categoriaData);
//             dd($categoriaId);



            return $categoriaId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}