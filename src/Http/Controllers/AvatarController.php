<?php

namespace MiniRest\Http\Controllers;

use MiniRest\Actions\User\UserGetAvatarAction;
use MiniRest\Actions\User\UserUploadAvatarAction;
use MiniRest\Exceptions\AvatarNotFoundException;
use MiniRest\Exceptions\UploadErrorException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;

class AvatarController
{

    public function uploadAvatar(Request $request)
    {
        $userId = Auth::id($request);

        $validation = $request->rules([
            'avatar' => 'required|file:png,jpg,jpeg',
        ])->validate('files');;

        if (!$validation) {
            $request->errors();
            return;
        }

        try {
            $avatar = (new UserUploadAvatarAction())->execute($request, $userId);

            Response::json(['success' => ['message' => 'Upload efetuado com sucesso', 'avatar_url' => asset("avatar/" . $avatar)]]);
        } catch (UploadErrorException $e) {
            Response::json(['error' => ['message' => 'Error ao fazer o upload do arquivo']], $e->getCode());
            return;
        }
    }
    
    public function avatar(Request $request, ?int $userId)
    {
        if (!$userId) $userId = Auth::id($request);
        try {
            $avatar = (new UserGetAvatarAction())->execute($userId);
            Response::json(['success' => ['avatar_url' => asset("avatar/" . $avatar)]]);
        } catch (AvatarNotFoundException $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
            return;
        }

    }
}