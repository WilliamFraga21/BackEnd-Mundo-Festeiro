<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class TamanhoDTO implements DTO
{
    public string $tamanho;



    public function __construct(
        protected Request $request,
    )
    {
        $this->tamanho         = $request->json('Tamanho');


    }



    public function toArray(): array
    {
        return [
            'Tamanho' => $this->tamanho,

        ];
    }

}