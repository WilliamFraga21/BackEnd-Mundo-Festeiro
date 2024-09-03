<?php


namespace MiniRest\Models\Produto\Produto;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{


    protected $table = 'produtos';
    protected $fillable = [
        'Nome_Produto',
        'Descricao',
        'categorias_id',
        'subcategorias_id',
    ];
}