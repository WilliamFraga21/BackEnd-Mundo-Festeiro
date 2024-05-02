<?php

namespace MiniRest\Models\Prestador;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MiniRest\Models\User;

class Prestador extends Model
{
    use SoftDeletes;
    protected $table = 'prestador';

    protected $fillable = [
        'promotorEvento',
        'users_id',
        'localidade_id',
        'curriculo',
    ];

    protected $hidden = [
        'Senha', # precisa desse hidden por conta do getById da proposta e serviço - Senha do user
    ];
    protected $dates = ['deleted_at'];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}