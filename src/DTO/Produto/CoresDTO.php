<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class CoresDTO implements DTO
{
    public string $cor;
    public string $codigoCor;



    public function __construct(
        protected Request $request,
    )
    {
        $this->cor         = $request->json('Cor');
        $this->codigoCor         = $request->json('Codigo_Cor');


    }



    public function toArray(): array
    {
        return [
            'Cor' => $this->cor,
            'Codigo_Cor' => $this->codigoCor,

        ];
    }

}