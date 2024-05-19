<?php

namespace MiniRest\Repositories;

use MiniRest\Models\Photos;

class AvatarRepository
{
    private Photos $photos;

    public function __construct()
    {
        $this->photos = new Photos();
    }

    public function storeAvatar(int $id, string $fileName)
    {
        return $this->photos
            ->firstOrCreate(
                ['users_id' => $id],
                ['avatar' => $fileName]
            );
    }
    
    public function updateAvatar(int $id, string $fileName)
    {
        return $this->photos
            ->createOrUpdate(
                ['users_id' => $id],
                ['avatar' => $fileName]
            );
    }

    public function getUserAvatar(int $id)
    {
        return $this->photos->select('avatar')->where('users_id', '=', $id)->value('avatar');
    }
}