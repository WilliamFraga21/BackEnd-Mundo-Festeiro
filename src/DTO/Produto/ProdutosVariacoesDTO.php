<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ProdutosVariacoesDTO implements DTO
{
    public int $cores;
    public float $valor;
    public int $tamanho;

    public int $produtos;
    public int $estoque;



    public function __construct(
        protected Request $request,
    )
    {
        $this->valor         = $request->json('Valor');
        $this->cores         = $request->json('cores_id');
        $this->tamanho         = $request->json('tamanho_id');
        $this->produtos         = $request->json('produtos_id');
        $this->estoque         = $request->json('QuantidadeEstoque');


    }



    public function toArray(): array
    {
        return [
            'Valor' => $this->valor,
            'cores_id' => $this->cores,
            'tamanho_id' => $this->tamanho,
            'produtos_id' => $this->produtos,
            'QuantidadeEstoque' => $this->estoque,

        ];
    }

}