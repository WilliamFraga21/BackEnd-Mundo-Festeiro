<?php


namespace MiniRest\Repositories\SubProdutos;

use MiniRest\Models\Produto\SubProdutos\Cores;

class CoresRepository
{
    private Cores $cores;

    public function __construct()
    {
        $this->cores = new Cores();
    }

    public function storeCores(array $data)
    {
        $id = $this->cores
            ->firstOrCreate(
                [
                    'Cor' => $data['Cor'],
                    'Codigo_Cor' => $data['Codigo_Cor'],
                ]
            );


        return $id->id;

    }



    public function getCores()
    {
        return $this->cores->select('id','Cor','Codigo_Cor')->get();
    }
}