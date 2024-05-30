<?php

namespace MiniRest\Actions\User;

use MiniRest\DTO\AddressCreateDTO;
use MiniRest\DTO\User\UserCreateDTO;
use MiniRest\Repositories\AddressRepository;
use MiniRest\Repositories\UserRepository;
use MiniRest\Repositories\Localidade\LocalidadeRepository;

class UserCreateAction
{
    public function __construct()
    {}

    public function execute(UserCreateDTO $userDTO)
    {
        $user = $userDTO->toArray();
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $idLocalidade = (new LocalidadeRepository())->storeLocalidade($user);
        (new userRepository())->store($user,$idLocalidade);
    }
}