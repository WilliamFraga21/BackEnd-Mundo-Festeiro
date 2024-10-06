<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\CupomDTO;
use MiniRest\Repositories\CupomRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class CupomCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(CupomDTO $cupomCreateDTO)
    {
        $cupomData = $cupomCreateDTO->toArray();


        try {

            $categoriaId = (new CupomRepository())->storeCupom($cupomData);
//             dd($categoriaId);



            return $categoriaId;

        } catch (DatabaseInsertException $exception) {

            throw new $exception;
        }
    }
}