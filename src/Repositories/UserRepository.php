<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Photos;
use MiniRest\Models\User;
use MiniRest\Models\Carrinho\Carrinho;
use MiniRest\Models\Localidade\Localidade;

class UserRepository
{
    protected User $user;
    protected Carrinho $carrinho;
    protected Photos $Photos;
    protected Localidade $localidade;

    public function __construct()
    {
        $this->carrinho = new Carrinho();
        $this->user = new User();
        $this->Photos = new Photos();
        $this->localidade = new Localidade();
    }

    public function getAll()
    {
        return $this->user
            ->select('*')
            ->get();
    }

    public function me(int $userId)
    {
        $user = $this->user->where('id', '=', $userId)
            ->first();

        $localidadeinfo = $this->localidade->where('id', '=', $user->localidade_id)->first();
        // dd($localidadeinfo);
        return [
            'user' => $user,
            'localidade' => $localidadeinfo,
        ];
    }

    public function store(array $user,$localidade)
    {
        $idUser = $this->user->create([
            'name' => $user['name'],
            'email' => $user['email'],
            'contactno' => $user['contactno'],
            'password' => $user['password'],
            'localidade_id' => $localidade,
            'idade' => $user['idade'],
        ]);


        $idCarrinho = $this->carrinho->create(
            [
                'users_id' => $idUser->id
            ]
        );


//         dd($idCarrinho->id);
    }

    public function update(int $id, array $user,$localidade)
    {
        $this->user->where('id', '=', $id)->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'contactno' => $user['contactno'],
            'password' => $user['password'],
            'localidade_id' => $localidade,
            'idade' => $user['idade'],

        ]);
    }

    public function remove(int $id, array $user)
    {
        $this->user->where('id', '=', $id)->update($user);
    }
}