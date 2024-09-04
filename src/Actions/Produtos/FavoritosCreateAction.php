<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\FavoritosDTO;
use MiniRest\Repositories\FavoritosRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class FavoritosCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $idProduto,int $idUser)
    {


        try {
            $produtoId = (new FavoritosRepository())->store($idProduto,$idUser);



            return $produtoId;

        } catch (DatabaseInsertException $exception) {

            throw new $exception;
        }
    }
}