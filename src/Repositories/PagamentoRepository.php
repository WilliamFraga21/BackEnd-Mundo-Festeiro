<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Pagamentos;
use MiniRest\Models\Cupom;

class PagamentoRepository
{
    private Pagamentos $pagamentos;
    private Cupom $cupom;

    public function __construct()
    {
        $this->pagamentos = new Pagamentos();
        $this->cupom = new Cupom();
    }

    public function storepagamento(array $data,int $userID)
    {


        $pagamentos = $this->pagamentos->create(
            [
                'Valor' => $data['Valor'],
                'Metodo_Pagamento' =>$data['Metodo_Pagamento'],
                'Status' => 'Aguardando Aprovação',
                'Data_Pagamento' =>$data['Data_Pagamento'],
                'pedido_id'=>$data['pedido_id'],
                'pedido_users_id'=>$userID,
                'localidade_id'=>$data['localidade_id'],
//                'cupom_id'=>$data['cupom_id'],
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