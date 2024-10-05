<?php


namespace MiniRest\Models\Produto\Produto;

use Illuminate\Database\Eloquent\Model;

class ProdutosVariasoes extends Model
{


    protected $table = 'produtosvariasoes';
    protected $fillable = [
        'Valor',
        'cores_id',
        'tamanho_id',
        'produtos_id',
        'estoque_id',
        'Status',
        'promo_id',
    ];
}