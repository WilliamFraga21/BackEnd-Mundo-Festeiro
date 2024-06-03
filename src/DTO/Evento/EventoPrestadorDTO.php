<?php

namespace MiniRest\DTO\Evento;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class EventoPrestadorDTO implements DTO
{
    private Request $request;
    private string $profissao;
    private int $evento_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->profissao = $this->request->json('profissao');
        $this->evento_id = $this->request->json('evento_id');
    }

    function toArray(): array
    {
        return [
            'profissao' => $this->profissao,
            'evento_id' => $this->evento_id,
        ];
    }
}