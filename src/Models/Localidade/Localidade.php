<?php

namespace MiniRest\Models\Localidade;

use Illuminate\Database\Eloquent\Model;

class Localidade extends Model
{
    protected $table = 'localidade';

    protected $fillable = [
        'endereco',
        'bairro',
        'cidade',
        'estado',
    ];

    protected $hidden = [
        'Senha', # precisa desse hidden por conta do getById da proposta e serviço - Senha do user
    ];

}