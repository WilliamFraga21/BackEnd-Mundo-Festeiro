<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
class Pagamentos extends Model
{

    protected $table = 'pagamentos';
    protected $fillable = [
        'Valor',
        'Metodo_Pagamento',
        'Status',
        'Data_Pagamento',
        'pedido_id',
        'pedido_users_id',
        'localidade_id',
        'cupom_id',
    ];
}