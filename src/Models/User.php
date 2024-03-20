<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;
use MiniRest\Models\Prestador\Prestador;

class User extends Model
{

    protected $table = 'users';
    protected $fillable = [
        'name' ,
        'email',
        'contactno' ,
        'password',
        'shippingAddress' ,
        'shippingState' ,
        'shippingCity' ,
        'shippingPincode' ,
        'billingAddress' ,
        'billingState' ,
        'billingCity',
        'billingPincode' ,
        'regDate' ,
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public static $rules = [
        'email' => 'required|email|unique:users',
    ];


    public function prestador(): hasOne 
    {
        return $this->hasOne(Prestador::class);
    }

}