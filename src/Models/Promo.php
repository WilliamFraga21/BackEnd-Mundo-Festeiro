<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
class Promo extends Model
{

    protected $table = 'promo';
    protected $fillable = [
        'Porcentagem',
        'Tempo',
        'Status',
    ];
}