<?php

namespace MiniRest\DTO\Evento;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class EventoPrestadorDTO implements DTO
{
    private Request $request;
    private int $prestador_id;
    private int $evento_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->prestador_id = $this->request->json('prestador_id');
        $this->evento_id = $this->request->json('evento_id');
    }

    function toArray(): array
    {
        return [
            'prestador_id' => $this->prestador_id,
            'evento_id' => $this->evento_id,
        ];
    }
}