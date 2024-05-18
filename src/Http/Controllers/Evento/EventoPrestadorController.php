<?php

namespace MiniRest\Http\Controllers\Evento;

use MiniRest\Actions\Evento\EventoPrestadorCreateAction;
use MiniRest\DTO\Evento\EventoPrestadorDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\RuleNotFound;
use MiniRest\Exceptions\InvalidJsonResponseException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;

class EventoPrestadorController extends Controller
{
    public function store(Request $request)
    {   
        $validation = $request->rules([
            'prestador_id' => 'required',
            'evento_id' => 'required',
            'aceitarPrestador' => 'required',
            ])->validate();
            
            if (!$validation) {
                $request->errors();
                return;
            }
        try {
            $eventoId = (new EventoPrestadorCreateAction())->execute(
                Auth::id($request),
                new EventoPrestadorDTO($request)
            );
            if ($eventoId == 'Usuário sem Permissão') {
                Response::json(['error' => 'Usuário sem Permissão'], StatusCode::SERVER_ERROR);
            }elseif($eventoId == 'Prestador não encontrado') {
                Response::json(['error' => 'Prestador não encontrado'], StatusCode::SERVER_ERROR);
            }else{
                Response::json(['success' => ['message' => 'Prestador aceito com sucesso','infos' => $eventoId]]);
            }
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }
}