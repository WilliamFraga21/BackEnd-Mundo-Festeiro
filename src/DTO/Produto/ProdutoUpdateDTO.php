<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ProdutoUpdateDTO implements DTO
{
    public string $nome;
    public string $descricao;
    public int $subCategoriaID;
    public int $produtoID;



    public function __construct(
        protected Request $request,
    )
    {
        $this->nome         = $request->json('Nome_Produto');
        $this->descricao         = $request->json('Descricao');
        $this->subCategoriaID         = $request->json('subcategorias_id');
        $this->produtoID         = $request->json('ProdutoID');


    }



    public function toArray(): array
    {
        return [
            'Nome_Produto' => $this->nome,
            'Descricao' => $this->descricao,
            'subcategorias_id' => $this->subCategoriaID,
            'ProdutoID' => $this->produtoID,

        ];
    }

}