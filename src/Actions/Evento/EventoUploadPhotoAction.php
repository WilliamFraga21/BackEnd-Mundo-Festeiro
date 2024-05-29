<?php

namespace MiniRest\Actions\Evento;

use MiniRest\Exceptions\UploadErrorException;
use MiniRest\Http\Request\Request;
use MiniRest\Repositories\Evento\EventoRepository;
use MiniRest\Storage\Acl\PublicAcl;
use MiniRest\Storage\DiskStorage;
use MiniRest\Storage\UUIDFileName;
use PDOException;

class EventoUploadPhotoAction
{
    /**
     * @throws UploadErrorException
     */
    public function execute(Request $request, int $eventoId): string
    {
        $basePath = __DIR__ . '/../../../storage/';
        $file = $request->files('img');
        $storage = new DiskStorage($basePath);
        // dd($file);
        $name = UUIDFileName::uuidFileName($file['name']);
        try {
            $avatar = (new EventoRepository())->storePhoto($eventoId, $name);
            $storage->put("evento/" . $name, $file['tmp_name']);
            return $name;
        } catch (PDOException $exception) {
            throw new UploadErrorException($exception->getMessage());
        }
        
    }

}