<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Pagamentos;
use MiniRest\Models\Cupom;

class CupomRepository
{
    private Pagamentos $pagamentos;
    private Cupom $cupom;

    public function __construct()
    {
        $this->pagamentos = new Pagamentos();
        $this->cupom = new Cupom();
    }

    public function storeCupom(array $data)
    {

        $pagamentos = $this->cupom->create(
            [
                'Codigo' => $data['Codigo'],
                'Tempo' =>$data['Tempo'],
                'Status' =>$data['Status'],

            ]
        );



        return $pagamentos;


    }



    public function updateStatus(int $id,int $status)
    {


        $pagamentos = $this->pagamentos->where('id',$id)->update(
            [
                'status'=>$status,
            ]
        );



        return $pagamentos;
    }
}