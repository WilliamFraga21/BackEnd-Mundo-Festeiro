<?php

namespace MiniRest\Actions\Produtos;

use MiniRest\DTO\Produto\AddPromoDTO;
use MiniRest\Repositories\Produtos\PromoRepository;
use MiniRest\Exceptions\DatabaseInsertException;

class PromoAddPromoAction
{
    public function __construct()
    {}

    /**
     * @throws DatabaseInsertException
     */
    public function execute(AddPromoDTO $promoCreateDTO)
    {
        $promoData = $promoCreateDTO->toArray();


        try {

            $Id = (new PromoRepository())->addPromoProduto($promoData);
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