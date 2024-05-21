<?php

namespace MiniRest\Actions\User;

use MiniRest\Exceptions\UploadErrorException;
use MiniRest\Http\Request\Request;
use MiniRest\Repositories\AvatarRepository;
use MiniRest\Storage\Acl\PublicAcl;
use MiniRest\Storage\DiskStorage;
use MiniRest\Storage\UUIDFileName;
use PDOException;

class EventoUploadPhotosAction
{ /**
     * @throws UploadErrorException
     */
    public function execute(Request $request, int $userId): string
    {
        $basePath = __DIR__ . '/../../../storage/';
        $file = $request->files('avatar');
        $storage = new DiskStorage($basePath);
        $name = UUIDFileName::uuidFileName($file['name']);
        try {
            $avatar = (new AvatarRepository())->storeAvatar($userId, $name);
            $storage->put("Evento/" . $name, $file['tmp_name']);
            return $name;
        } catch (PDOException $exception) {
            throw new UploadErrorException($exception->getMessage());
        }
        
    }

}