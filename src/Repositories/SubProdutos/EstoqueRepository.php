<?php


namespace MiniRest\Repositories\SubProdutos;

use MiniRest\Models\Produto\SubProdutos\Estoque;

class EstoqueRepository
{
    private Estoque $estoque;

    public function __construct()
    {
        $this->estoque = new Estoque();
    }

    public function storeEstoque(string $valor)
    {
        $id = $this->estoque
            ->create(
                [
                    'Quantidade' => $valor,
                ]
            );


        return $id->id;

    }


    public function getEstoque()
    {
        return $this->estoque->select('id', 'Quantidade')->get();
    }
}