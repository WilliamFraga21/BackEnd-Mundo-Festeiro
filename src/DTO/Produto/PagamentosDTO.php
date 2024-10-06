<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class PagamentosDTO implements DTO
{
    public float $Valor;
    public string $Metodo_Pagamento;
    public string $Data_Pagamento;
    public int $pedido_id;
    public int $pedido_users_id;

    public int $localidade_id;
    public int $cupom_id;






    public function __construct(
        protected Request $request,
    )
    {
        $this->Valor         = $request->json('Valor');
        $this->Metodo_Pagamento        = $request->json('Metodo_Pagamento');
        $this->Data_Pagamento         = $request->json('Data_Pagamento');
        $this->pedido_users_id         = $request->json('pedido_users_id');
        $this->pedido_id         = $request->json('pedido_id');
        $this->localidade_id         = $request->json('localidade_id');
        $this->cupom_id         = $request->json('cupom_id');


    }



    public function toArray(): array
    {
        return [
            'Valor' => $this->Valor,
            'Metodo_Pagamento' => $this->Metodo_Pagamento,
            'Data_Pagamento' => $this->Data_Pagamento,
            'pedido_users_id' => $this->pedido_users_id,
            'pedido_id' => $this->pedido_id,
            'localidade_id' => $this->localidade_id,
            'cupom_id' => $this->cupom_id,

        ];
    }

}