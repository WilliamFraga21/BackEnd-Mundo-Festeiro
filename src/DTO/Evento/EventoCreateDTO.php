<?php

namespace MiniRest\DTO\Evento;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class EventoCreateDTO implements DTO
{
    private Request $request;
    private string $nomeEvento;
    private string $tipoEvento;
    private int $quantidadePessoas;
    private int $quantidadeFuncionarios;
    private string $statusEvento;
    private string $descricaoEvento;
    private string $endereco;
    private string $bairro;
    private string $cidade;
    private string $estado;
    private array $professions;
    private int $users_id;
    private int $localidade_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->nomeEvento = $this->request->json('nomeEvento');
        $this->tipoEvento = $this->request->json('tipoEvento');
        $this->quantidadePessoas = $this->request->json('quantidadePessoas');
        $this->quantidadeFuncionarios = $this->request->json('quantidadeFuncionarios');
        $this->statusEvento = $this->request->json('statusEvento');
        $this->descricaoEvento = $this->request->json('descricaoEvento');
        $this->endereco = $this->request->json('endereco');
        $this->bairro = $this->request->json('bairro');
        $this->cidade = $this->request->json('cidade');
        $this->estado = $this->request->json('estado');
        $this->professions = $this->request->json('professions');
    }

    function toArray(): array
    {
        return [
            'nomeEvento' => $this->nomeEvento,
            'tipoEvento' => $this->tipoEvento,
            'quantidadePessoas' => $this->quantidadePessoas,
            'quantidadeFuncionarios' => $this->quantidadeFuncionarios,
            'statusEvento' => $this->statusEvento,
            'statusEvento' => $this->statusEvento,
            'descricaoEvento' => $this->descricaoEvento,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'professions' => $this->professions,
        ];
    }
}