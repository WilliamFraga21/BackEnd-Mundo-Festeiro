<?php

namespace MiniRest\Models\Pedido;

use Illuminate\Database\Eloquent\Model;
class ItensPedido extends Model
{

    protected $table = 'itenspedido';
    protected $fillable = [
        'Quantidade',
        'Valor_Uni',
        'pedido_id',
        'pedido_users_id',
        'produtosvariasoes_id',
    ];
}