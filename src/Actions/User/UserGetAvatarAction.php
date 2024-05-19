<?php

namespace MiniRest\Actions\User;

use MiniRest\Exceptions\AvatarNotFoundException;
use MiniRest\Repositories\AvatarRepository;
use MiniRest\Storage\DiskStorage;
use PDOException;

class UserGetAvatarAction
{
    /**
     * @throws AvatarNotFoundException
     */
    public function execute(int $userId): string
    {
        $basePath = __DIR__ . '/../../../storage/';
        $storage = new DiskStorage($basePath);

        $name = (new AvatarRepository())->getUserAvatar($userId);

        if (strlen($name) < 1) {
            throw new AvatarNotFoundException();
        }

        return ($storage->get("avatar/" . $name));
    }
}