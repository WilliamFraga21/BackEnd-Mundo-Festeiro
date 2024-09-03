<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class CategoriasDTO implements DTO
{
    public string $categoria;



    public function __construct(
        protected Request $request,
    )
    {
        $this->categoria         = $request->json('Categoria');


    }



    public function toArray(): array
    {
        return [
            'Categoria' => $this->categoria,

        ];
    }

}