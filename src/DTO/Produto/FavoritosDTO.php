<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class FavoritosDTO implements DTO
{
    public int $userID;
    public int $ProdutoID;



    public function __construct(
        protected Request $request,
    )
    {
        $this->userID         = $request->json('users_id');
        $this->ProdutoID         = $request->json('produtosvariasoes_id');


    }



    public function toArray(): array
    {
        return [
            'users_id' => $this->userID,
            'produtosvariasoes_id' => $this->ProdutoID,

        ];
    }

}