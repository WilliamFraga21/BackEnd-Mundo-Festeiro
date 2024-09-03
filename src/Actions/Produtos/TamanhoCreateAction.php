<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\TamanhoDTO;
use MiniRest\Repositories\SubProdutos\TamanhoRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class TamanhoCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(TamanhoDTO $tamanhoCreateDTO)
    {
        $tamanhoData = $tamanhoCreateDTO->toArray();


        try {

            $tamanhoId = (new TamanhoRepository())->storeTamanho($tamanhoData);
            // dd($tamanhoId);



            return $tamanhoId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}