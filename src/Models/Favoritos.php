<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Favoritos extends Model
{

    use SoftDeletes;
    protected $table = 'favoritos';
    protected $fillable = [
        'users_id',
        'produtosvariasoes_id',
    ];
    protected $dates = ['deleted_at'];
}