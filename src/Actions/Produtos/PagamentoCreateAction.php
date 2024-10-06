<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\PagamentosDTO;
use MiniRest\Repositories\PagamentoRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class PagamentoCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(PagamentosDTO $pagamentoCreateDTO,$idUser)
    {
        $pagamentoData = $pagamentoCreateDTO->toArray();


        try {

            $categoriaId = (new PagamentoRepository())->storepagamento($pagamentoData,$idUser);
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