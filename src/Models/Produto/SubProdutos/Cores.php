<?php


namespace MiniRest\Models\Produto\SubProdutos;

use Illuminate\Database\Eloquent\Model;

class Cores extends Model
{


    protected $table = 'cores';
    protected $fillable = [
        'Cor',
        'Codigo_Cor',
    ];
}