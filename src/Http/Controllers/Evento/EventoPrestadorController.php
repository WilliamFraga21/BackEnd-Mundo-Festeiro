<?php

namespace MiniRest\Http\Controllers\Evento;

use MiniRest\Actions\Evento\EventoPrestadorCreateAction;
use MiniRest\DTO\Evento\EventoPrestadorDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\RuleNotFound;
use MiniRest\Exceptions\InvalidJsonResponseException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Repositories\Evento\EventoPrestadorRepository;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;

class EventoPrestadorController extends Controller
{
    private EventoPrestadorRepository $Evento;


    public function __construct()
    {
        $this->Evento = new EventoPrestadorRepository();
    }
    public function store(Request $request)
    {   
        $validation = $request->rules([
            'prestador_id' => 'required',
            'evento_id' => 'required',
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
                Response::json(['error' => 'Usuário sem Permissão'], StatusCode::ACCESS_NOT_ALLOWED);
            }elseif($eventoId == 'Prestador não encontrado') {
                Response::json(['error' => 'Prestador não encontrado'], StatusCode::ACCESS_NOT_ALLOWED);
            }else{
                Response::json(['success' => ['message' => 'Prestador aceito com sucesso','infos' => $eventoId]]);
            }
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }
    public function getPrestadores(int $id,Request $request)
    {   
    
        try {
        
            if ( $this->Evento->getPrestadores($id) == "Evento não encontrado") {
                Response::json(['error' => "Evento não encontrado"], StatusCode::ACCESS_NOT_ALLOWED);

            }elseif  ($this->Evento->getPrestadores($id) == 'Nenhum prestador encontrado para o evento.') {
                Response::json(['error' => 'Nenhum prestador encontrado para o evento.'], StatusCode::ACCESS_NOT_ALLOWED);

            } else {
                Response::json(['prestadores' => $this->Evento->getPrestadores($id)]);
            }
            
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }    
    public function aceitarproposta(int $id,Request $request)
    {   
    
        try {
        
            if ( $this->Evento->aceitar($id,Auth::id($request)) == null) {
                Response::json(['error' => "Proposta não encontrada."], StatusCode::ACCESS_NOT_ALLOWED);

            } else {
                $proposta = $this->Evento->aceitar($id,Auth::id($request));
                Response::json(['success' => ['message' => 'Proposta Aceitar com sucesso']]);
            }
            
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }
}