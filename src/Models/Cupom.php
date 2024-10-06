<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
class Cupom extends Model
{

    protected $table = 'cupom';
    protected $fillable = [
        'Codigo',
        'Tempo',
        'Status',
    ];
}