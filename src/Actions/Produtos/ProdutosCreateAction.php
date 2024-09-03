<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\ProdutosDTO;
use MiniRest\Repositories\Produtos\ProdutosRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class ProdutosCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(ProdutosDTO $produtoCreateDTO)
    {
        $produtoData = $produtoCreateDTO->toArray();


        try {
//            dd($produtoData);
            $produtoId = (new ProdutosRepository())->storeProdutos($produtoData);
//             dd($produtoId);



            return $produtoId;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}