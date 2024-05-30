<?php

namespace MiniRest\Models\Prestador;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class PrestadorAceitar extends Model
{

    // use SoftDeletes;
    protected $table = 'contrar_prestador';
    protected $fillable = [
        'aceitarProposta',
        'prestador_id',
        'users_id',
    ];
    // protected $dates = ['deleted_at'];
}