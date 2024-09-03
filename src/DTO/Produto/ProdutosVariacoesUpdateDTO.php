<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ProdutosVariacoesUpdateDTO implements DTO
{
    public float $valor;

    public int $produtos;
    public int $estoque;
    public int $estoqueID;



    public function __construct(
        protected Request $request,
    )
    {
        $this->valor         = $request->json('Valor');
        $this->produtos         = $request->json('produtos_id');
        $this->estoque         = $request->json('QuantidadeEstoque');
        $this->estoqueID         = $request->json('estoque_id');


    }



    public function toArray(): array
    {
        return [
            'Valor' => $this->valor,
            'produtos_id' => $this->produtos,
            'QuantidadeEstoque' => $this->estoque,
            'estoque_id' => $this->estoqueID,

        ];
    }

}