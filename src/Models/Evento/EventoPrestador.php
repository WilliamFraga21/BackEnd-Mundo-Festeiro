<?php

namespace MiniRest\Models\Evento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EventoPrestador extends Model
{

    use SoftDeletes;
    protected $table = 'prestador_has_evento';
    protected $fillable = [
        'prestador_id',
        'evento_id',
        'aceitarPrestador',
    ];
    protected $dates = ['deleted_at'];
}