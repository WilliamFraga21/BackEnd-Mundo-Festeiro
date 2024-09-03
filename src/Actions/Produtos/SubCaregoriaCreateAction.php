<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\SubCategoriaDTO;
use MiniRest\Repositories\SubProdutos\SubCategoriasRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class SubCaregoriaCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(SubCategoriaDTO $subCateriaCreateDTO)
    {
        $subCategoriaData = $subCateriaCreateDTO->toArray();


        try {

            $categoriaId = (new SubCategoriasRepository())->storeCategoria($subCategoriaData);
            // dd($tamanhoId);



            return $categoriaId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}