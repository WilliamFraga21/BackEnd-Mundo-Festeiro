<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class AddPromoDTO implements DTO
{
    public int $id;
    public int $idpromo;



    public function __construct(
        protected Request $request,
    )
    {
        $this->id         = $request->json('id');
        $this->idpromo         = $request->json('idpromo');


    }



    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'idpromo' => $this->idpromo,

        ];
    }

}