<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Photos;
use MiniRest\Models\User;

class UserRepository
{
    protected User $user;
    protected Photos $Photos;

    public function __construct()
    {
        $this->user = new User();
        $this->Photos = new Photos();
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



        return [
            'user' => $user,
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
        ]);
        // dd($idUser);
    }

    public function update(int $id, array $user,$localidade)
    {
        $this->user->where('id', '=', $id)->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'contactno' => $user['contactno'],
            'password' => $user['password'],
            'localidade_id' => $localidade,
        ]);
    }

    public function remove(int $id, array $user)
    {
        $this->user->where('id', '=', $id)->update($user);
    }
}