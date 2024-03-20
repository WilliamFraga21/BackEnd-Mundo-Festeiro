<?php

namespace MiniRest\Models\Prestador;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MiniRest\Models\User;

class Prestador extends Model
{
    protected $table = 'prestador';

    protected $fillable = [
        'promotorEvento',
        'users_id',
        'localidade_id',
    ];

    protected $hidden = [
        'Senha', # precisa desse hidden por conta do getById da proposta e serviço - Senha do user
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}