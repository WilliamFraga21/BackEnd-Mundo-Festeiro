<?php

namespace MiniRest\Http\Controllers\Evento;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Actions\Evento\EventoGetPhotoAction;
use MiniRest\Actions\Evento\EventoUploadPhotoAction;
use MiniRest\Exceptions\AvatarNotFoundException;
use MiniRest\Exceptions\UploadErrorException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\Evento\EventoRepository;
class EventoPhotoController
{ 
    private EventoRepository $evento;

    public function __construct()
    {
        $this->evento = new EventoRepository();
    }
    public function uploadPhoto(int $id,Request $request)
    {
        // $userId = Auth::id($request);

        $validation = $request->rules([
            'img' => 'required|file:png,jpg,jpeg',
        ])->validate('files');;

        if (!$validation) {
            $request->errors();
            return;
        }

        try {
            // dd($request);
            if ($this->evento->ifUserEventoPhoto(Auth::id($request))) {
                $avatar = (new EventoUploadPhotoAction())->execute($request,$id);
                Response::json(['success' => ['message' => 'Upload efetuado com sucesso', 'img_url' => asset("evento/" . $avatar)]]);
                # code...
            }else{

                Response::json(['error' => ['message' => 'Você não pode colocar foto em evento de outros usuários']], StatusCode::ACCESS_NOT_ALLOWED);
            }


        } catch (UploadErrorException $e) {
            Response::json(['error' => ['message' => 'Error ao fazer o upload do arquivo']], $e->getCode());
            return;
        }
    }
    
    public function photo(Request $request, ?int $userId)
    {
        if (!$userId) $userId = Auth::id($request);
        try {
            $avatar = (new EventoGetPhotoAction())->execute($userId);
            Response::json(['success' => ['img_url' => asset("evento/" . $avatar)]]);
        } catch (AvatarNotFoundException $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
            return;
        }

    }
}