<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ProdutosDTO implements DTO
{
    public string $nome;
    public string $descricao;
    public int $categoriaID;
    public int $subCategoriaID;



    public function __construct(
        protected Request $request,
    )
    {
        $this->nome         = $request->json('Nome_Produto');
        $this->descricao         = $request->json('Descricao');
        $this->categoriaID         = $request->json('categorias_id');
        $this->subCategoriaID         = $request->json('subcategorias_id');


    }



    public function toArray(): array
    {
        return [
            'Nome_Produto' => $this->nome,
            'Descricao' => $this->descricao,
            'categorias_id' => $this->categoriaID,
            'subcategorias_id' => $this->subCategoriaID,

        ];
    }

}