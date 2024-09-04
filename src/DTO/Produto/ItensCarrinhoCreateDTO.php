<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ItensCarrinhoCreateDTO implements DTO
{
    public float $valor;
    public int $quantidade;
    public int $ProdutoID;



    public function __construct(
        protected Request $request,
    )
    {
        $this->valor         = $request->json('Valor_Uni');
        $this->quantidade         = $request->json('Quantidade');
        $this->ProdutoID         = $request->json('produtosvariasoes_id');


    }



    public function toArray(): array
    {
        return [
            'Valor_Uni' => $this->valor,
            'Quantidade' => $this->quantidade,
            'produtosvariasoes_id' => $this->ProdutoID,

        ];
    }

}