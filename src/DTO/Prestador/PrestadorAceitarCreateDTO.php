<?php

namespace MiniRest\DTO\Prestador;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PrestadorAceitarCreateDTO implements DTO
{
    private Request $request;
    private string $profession;
    private int $idprestador;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->profession = $this->request->json('profession');
        $this->idprestador = $this->request->json('idprestador');
    }

    function toArray(): array
    {
        return [
            'profession' => $this->profession,
            'idprestador' => $this->idprestador,
        ];
    }
}