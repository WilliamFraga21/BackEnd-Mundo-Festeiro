<?php

namespace MiniRest\DTO\Prestador;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PrestadorCreateDTO implements DTO
{
    private Request $request;
    private int $promotorEvento;
    private string $endereco;
    private string $bairro;
    private string $cidade;
    private string $estado;
    private string $curriculo;
    private int $users_id;
    private int $localidade_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->promotorEvento = $this->request->json('promotorEvento');
        $this->endereco = $this->request->json('endereco');
        $this->bairro = $this->request->json('bairro');
        $this->cidade = $this->request->json('cidade');
        $this->estado = $this->request->json('estado');
        $this->curriculo = $this->request->json('curriculo');
    }

    function toArray(): array
    {
        return [
            'promotorEvento' => $this->promotorEvento,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'curriculo' => $this->curriculo,
        ];
    }
}