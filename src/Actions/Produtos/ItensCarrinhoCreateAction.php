<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\ItensCarrinhoCreateDTO;
use MiniRest\Repositories\ItensCarrinhoRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class ItensCarrinhoCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $idUser,ItensCarrinhoCreateDTO $carrinhoCreateDTO)
    {


        $itensData = $carrinhoCreateDTO->toArray();


        try {
//            dd($produtoData);
            $produtoId = (new ItensCarrinhoRepository())->store($itensData,$idUser);
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