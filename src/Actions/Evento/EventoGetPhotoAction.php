<?php

namespace MiniRest\Actions\Evento;

use MiniRest\Exceptions\AvatarNotFoundException;
use MiniRest\Repositories\Evento\EventoRepository;
use MiniRest\Storage\DiskStorage;
use PDOException;

class EventoGetPhotoAction
{
    /**
     * @throws AvatarNotFoundException
     */
    public function execute(int $userId): string
    {
        $basePath = __DIR__ . '/../../../storage';
        $storage = new DiskStorage($basePath);
        $name = (new EventoRepository())->getEventoPhoto($userId);
        if (strlen($name) < 1) {
            throw new AvatarNotFoundException();
        }
        return $name;
    }
}