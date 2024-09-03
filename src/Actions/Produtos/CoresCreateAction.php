<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\CoresDTO;
use MiniRest\Repositories\SubProdutos\CoresRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class CoresCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(CoresDTO $coresCreateDTO)
    {
        $coresData = $coresCreateDTO->toArray();


        try {

            $corId = (new CoresRepository())->storeCores($coresData);
            // dd($tamanhoId);



            return $corId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}