<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\ProdutoUpdateDTO;
use MiniRest\Repositories\Produtos\ProdutosRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class ProdutoUpdateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(ProdutoUpdateDTO $produtoCreateDTO)
    {
        $produtoData = $produtoCreateDTO->toArray();


        try {
//            dd($produtoData);
            $produtoId = (new ProdutosRepository())->updateProdutos($produtoData);
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