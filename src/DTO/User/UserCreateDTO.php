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
    public string $billingAddress;
    public string $billingState;
    public string $billingPincode;
    public string $regDate;
    public string $billingCity;


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
        $this->billingAddress                  = $request->json('billingAddress');
        $this->billingState                  = $request->json('billingState');
        $this->billingCity                  = $request->json('billingCity');
        $this->billingPincode                  = $request->json('billingPincode');
        $this->regDate                  = $request->json('regDate');

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
            'billingAddress' => $this->billingAddress,
            'billingState' => $this->billingState,
            'billingCity' => $this->billingCity,
            'billingPincode' => $this->billingPincode,
            'regDate' => $this->regDate,
        ];
    }

}