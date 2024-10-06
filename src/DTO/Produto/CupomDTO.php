<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class CupomDTO implements DTO
{
    public string $codigo;
    public string $tempo;
    public int $status;






    public function __construct(
        protected Request $request,
    )
    {
        $this->status         = $request->json('Status');
        $this->codigo        = $request->json('Codigo');
        $this->tempo         = $request->json('Tempo');



    }



    public function toArray(): array
    {
        return [
            'Status' => $this->status,
            'Codigo' => $this->codigo,
            'Tempo' => $this->tempo,


        ];
    }

}