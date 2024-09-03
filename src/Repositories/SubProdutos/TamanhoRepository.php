<?php


namespace MiniRest\Repositories\SubProdutos;

use MiniRest\Models\Produto\SubProdutos\Tamanho;

class TamanhoRepository
{
    private Tamanho $tamanho;

    public function __construct()
    {
        $this->tamanho = new Tamanho();
    }

    public function storeTamanho(array $data)
    {
        $id = $this->tamanho
            ->firstOrCreate(
                [
                    'Tamanho' => $data['Tamanho'],
                ],
                [
                    'Tamanho' => $data['Tamanho'],
                ]
            );


        return $id->id;

    }



    public function getTamanho()
    {
        return $this->tamanho->select('id','tamanho')->get();
    }
}