<?php

namespace MiniRest\DTO\User;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class UserCreateDTO implements DTO
{
    public string $id;
    public string $name;
    public string $email;
    public string $contactno;
    public string $password;
    public string $shippingAddress;
    public string $shippingState;
    public string $shippingCity;
    public string $shippingPincode;



    public function __construct(
        protected Request $request,
    )
    {
        $this->name         = $request->json('name');
        $this->email       = $request->json('email');
        $this->contactno               = $request->json('contactno');
        $this->password             = $request->json('password');
        $this->shippingAddress                = $request->json('shippingAddress');
        $this->shippingState                  = $request->json('shippingState');
        $this->shippingCity                  = $request->json('shippingCity');
        $this->shippingPincode                  = $request->json('shippingPincode');
        

    }



    public function toArray(): array
    {
        return [
            'name' => $this->name, 
            'email' => $this->email,
            'contactno' => $this->contactno, 
            'password' => $this->password,
            'shippingAddress' => $this->shippingAddress,
            'shippingState' => $this->shippingState,
            'shippingCity' => $this->shippingCity,
            'shippingPincode' => $this->shippingPincode,
            
        ];
    }

}