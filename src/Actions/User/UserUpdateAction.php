<?php

namespace MiniRest\Actions\User;

use MiniRest\DTO\User\UserCreateDTO;
use MiniRest\Repositories\UserRepository;

class UserUpdateAction
{
    public function __construct()
    {}

    public function execute(int $id,  UserCreateDTO $userDTO)
    {
        


        $user = $userDTO->toArray();
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        (new userRepository())->update($id, $user);
    }
}