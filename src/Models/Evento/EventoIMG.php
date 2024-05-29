<?php

namespace MiniRest\Models\Evento;

use Illuminate\Database\Eloquent\Model;

class EventoIMG extends Model
{
    protected $table = 'imgevento';

    protected $fillable = [
        'evento_id',
        'img'
    ];
}