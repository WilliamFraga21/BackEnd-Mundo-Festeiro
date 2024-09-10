<?php

namespace MiniRest\Models\Pedido;

use Illuminate\Database\Eloquent\Model;
class Pedido extends Model
{

    protected $table = 'pedido';
    protected $fillable = [
        'users_id',
        'Valor_Total',
        'Status',
    ];
}