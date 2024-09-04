<?php

namespace MiniRest\Models\Carrinho;

use Illuminate\Database\Eloquent\Model;
class Carrinho extends Model
{

    protected $table = 'carrinho';
    protected $fillable = [
        'users_id',
    ];
}