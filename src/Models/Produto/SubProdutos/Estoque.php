<?php


namespace MiniRest\Models\Produto\SubProdutos;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{


    protected $table = 'Estoque';
    protected $fillable = [
        'Quantidade',
    ];
}