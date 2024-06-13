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
    public string $endereco;
    public string $bairro;
    public string $cidade;
    public string $estado;
    public int $idade;



    public function __construct(
        protected Request $request,
    )
    {
        $this->name         = $request->json('name');
        $this->email       = $request->json('email');
        $this->contactno               = $request->json('contactno');
        $this->password             = $request->json('password');
        $this->endereco                = $request->json('endereco');
        $this->bairro                  = $request->json('bairro');
        $this->cidade                  = $request->json('cidade');
        $this->estado                  = $request->json('estado');
        $this->idade                 = $request->json('idade');
        

    }



    public function toArray(): array
    {
        return [
            'name' => $this->name, 
            'email' => $this->email,
            'contactno' => $this->contactno, 
            'password' => $this->password,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'idade' => $this->idade,
            
        ];
    }

}