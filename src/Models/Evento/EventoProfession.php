<?php

namespace MiniRest\Models\Evento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EventoProfession extends Model
{

    use SoftDeletes;
    protected $table = 'evento_has_profissao';
    protected $fillable = [
        'evento_id',
        'profissao_id',
    ];
    protected $dates = ['deleted_at'];
}