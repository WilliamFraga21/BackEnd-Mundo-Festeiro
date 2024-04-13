<?php

namespace MiniRest\Models\Prestador;

use Illuminate\Database\Eloquent\Model;

class PrestadorProfissao extends Model
{
    protected $table = 'prestador_has_profissao';
    protected $fillable = [
        'prestador_id',
        'profissao_id',
        'valorDiaServicoProfissao',
        'valorHoraServicoProfissao'
    ];
}