<?php


namespace MiniRest\Models\Produto\SubProdutos;

use Illuminate\Database\Eloquent\Model;

class SubCategorias extends Model
{


    protected $table = 'subcategorias';
    protected $fillable = [
        'SubCategoria',
        'categorias_id',
    ];
}