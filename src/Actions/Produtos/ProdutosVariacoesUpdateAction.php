<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\ProdutosVariacoesUpdateDTO;
use MiniRest\Repositories\Produtos\ProdutosVariacoesRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class ProdutosVariacoesUpdateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(ProdutosVariacoesUpdateDTO $variacoesCreateDTO)
    {
        $variacoesData = $variacoesCreateDTO->toArray();

        try {
            $produtoId = (new ProdutosVariacoesRepository())->updateProdutosVari($variacoesData);



            return $produtoId;

        } catch (DatabaseInsertException $exception) {

            throw new $exception;
        }
    }
}