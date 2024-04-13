<?php

namespace MiniRest\DTO\Prestador;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PrestadorProfessionCreateDTO implements DTO
{
    private Request $request;
    private array $profession;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->profession = $this->request->json('profession');
    }

    function toArray(): array
    {
        return [
            'profession' => $this->profession,
        ];
    }
}