<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{

    protected $table = 'chamada';
    protected $fillable = [
        'prestador_has_evento_id',
        'prestador_has_evento_prestador_id',
        'prestador_has_evento_evento_id',

    ];
}