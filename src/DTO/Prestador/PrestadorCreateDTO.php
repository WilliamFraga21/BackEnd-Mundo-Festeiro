<?php

namespace MiniRest\DTO\Prestador;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PrestadorCreateDTO implements DTO
{
    private Request $request;
    private int $promotorEvento;
    private string $curriculo;
    private int $users_id;
    private int $localidade_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->promotorEvento = $this->request->json('promotorEvento');
        $this->curriculo = $this->request->json('curriculo');
    }

    function toArray(): array
    {
        return [
            'promotorEvento' => $this->promotorEvento,
            'curriculo' => $this->curriculo,
        ];
    }
}