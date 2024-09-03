<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class SubCategoriaDTO implements DTO
{
    public int $categoriaID;
    public string $subCategoria;



    public function __construct(
        protected Request $request,
    )
    {
        $this->categoriaID         = $request->json('categorias_id');
        $this->subCategoria         = $request->json('SubCategoria');


    }



    public function toArray(): array
    {
        return [
            'categorias_id' => $this->categoriaID,
            'SubCategoria' => $this->subCategoria,

        ];
    }

}