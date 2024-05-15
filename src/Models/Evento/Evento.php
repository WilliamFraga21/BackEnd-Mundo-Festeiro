<?php

namespace MiniRest\Models\Evento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Evento extends Model
{

    use SoftDeletes;
    protected $table = 'evento';
    protected $fillable = [
        'nomeEvento',
        'tipoEvento',
        'quantidadePessoas',
        'quantidadeFuncionarios',
        'statusEvento',
        'descricaoEvento',
        'users_id',
        'localidade_id',
        'data'
    ];
    protected $dates = ['deleted_at'];
}