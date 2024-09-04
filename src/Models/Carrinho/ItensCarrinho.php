<?php

namespace MiniRest\Models\Carrinho;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItensCarrinho extends Model
{
    use SoftDeletes;

    protected $table = 'itenscarrinho';
    protected $fillable = [
        'Valor_Uni',
        'Quantidade',
        'carrinho_id',
        'carrinho_users_id',
        'produtosvariasoes_id',
    ];

    protected $dates = ['deleted_at'];

}