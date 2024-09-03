<?php


namespace MiniRest\Models\Produto\SubProdutos;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{


    protected $table = 'categorias';
    protected $fillable = [
        'Categoria',
    ];
}