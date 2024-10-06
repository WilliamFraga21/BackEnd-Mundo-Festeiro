<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Pagamentos;
use MiniRest\Models\Cupom;
use function PHPUnit\Framework\isEmpty;

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

    public function getCupom(){

        $cupom = $this->cupom->where('Status', 1)->get();

        if (!$cupom->isEmpty()) {
            return $cupom;  // Retorna os cupons encontrados
        } else {
            return 'Nenhum cupom encontrado';  // Mensagem de que não há cupons
        }




    }

    public function getCupomCodigo($id){

        $cupom = $this->cupom->where('Status', 1)->where('Codigo',$id)->first();

        if ($cupom) {
            return $cupom;  // Retorna os cupons encontrados
        } else {
            return 'Nenhum cupom encontrado';  // Mensagem de que não há cupons
        }




    }



    public function desativarCupom(int $id)
    {


        $data = $this->cupom->select('Status')->where('id',$id)->first();




        if($data->Status == 0){
            return 'Cupom já foi desativado';
        }else{

            $pagamentos = $this->cupom->where('id',$id)->update(
                [
                    'status'=> 0,
                ]
            );



            return $pagamentos;
        }



    }
}