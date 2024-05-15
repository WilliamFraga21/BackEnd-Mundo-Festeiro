<?php

namespace MiniRest\DTO\Evento;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class EventoProfessionCreateDTO implements DTO
{
    private Request $request;
    private string $evento_id;
    private string $profissao_id;
    private int $quantidade;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->evento_id = $this->request->json('evento_id');
        $this->profissao_id = $this->request->json('tipoprofissao_idEvento');
        $this->quantidade = $this->request->json('quantidade');
    }

    function toArray(): array
    {
        return [
            'evento_id' => $this->evento_id,
            'profissao_id' => $this->profissao_id,
            'quantidade' => $this->quantidade,
        ];
    }
}