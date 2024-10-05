<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Promo extends Model
{

    use SoftDeletes;
    protected $table = 'promo';
    protected $fillable = [
        'Porcentagem',
        'Tempo',
    ];
    protected $dates = ['deleted_at'];
}