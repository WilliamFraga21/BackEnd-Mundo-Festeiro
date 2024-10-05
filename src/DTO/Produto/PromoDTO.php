<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PromoDTO implements DTO
{
    public string $porcentagem;
    public string $tempo;



    public function __construct(
        protected Request $request,
    )
    {
        $this->porcentagem         = $request->json('Porcentagem');
        $this->tempo         = $request->json('Tempo');


    }



    public function toArray(): array
    {
        return [
            'Porcentagem' => $this->porcentagem,
            'Tempo' => $this->tempo,

        ];
    }

}