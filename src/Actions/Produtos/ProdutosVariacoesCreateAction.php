<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\ProdutosVariacoesDTO;
use MiniRest\Repositories\Produtos\ProdutosVariacoesRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class ProdutosVariacoesCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(ProdutosVariacoesDTO $variacoesCreateDTO)
    {
        $variacoesData = $variacoesCreateDTO->toArray();


        try {
            $produtoId = (new ProdutosVariacoesRepository())->storeProdutosVari($variacoesData);



            return $produtoId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}