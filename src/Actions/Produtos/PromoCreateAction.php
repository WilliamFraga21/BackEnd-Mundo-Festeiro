<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\PromoDTO;
use MiniRest\Repositories\Produtos\PromoRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class PromoCreateAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(PromoDTO $promoCreateDTO)
    {
        $promoData = $promoCreateDTO->toArray();


        try {

            $Id = (new PromoRepository())->storePromo($promoData);
            // dd($tamanhoId);



            return $Id;

        } catch (\Exception $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}