<?php

namespace MiniRest\Models\Prestador;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PrestadorProfissao extends Model
{

    use SoftDeletes;
    protected $table = 'prestador_has_profissao';
    protected $fillable = [
        'prestador_id',
        'profissao_id',
        'valorDiaServicoProfissao',
        'valorHoraServicoProfissao',
        'tempoexperiencia'
    ];
    protected $dates = ['deleted_at'];
}