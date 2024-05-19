<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = 'avatar';

    protected $fillable = [
        'users_id',
        'avatar'
    ];
}