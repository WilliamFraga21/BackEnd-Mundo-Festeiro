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
            'profissao' => 'required',
            'evento_id' => 'required',
            ])->validate();
            
            if (!$validation) {
                $request->errors();
                return;
            }
        try {
            $prestador = $this->Evento->getPrestador(Auth::id($request));
            // dd($prestador->id);
            $eventoId = (new EventoPrestadorCreateAction())->execute(
                // Auth::id($request),
                $prestador->id,
                new EventoPrestadorDTO($request)
            );
            if ($eventoId == 'Usuário sem Permissão') {
                Response::json(['error' => 'Usuário sem Permissão'], StatusCode::ACCESS_NOT_ALLOWED);
            }elseif($eventoId == 'Prestador não encontrado') {
                Response::json(['error' => 'Prestador não encontrado'], StatusCode::ACCESS_NOT_ALLOWED);
            }elseif($eventoId == 'Profissão Sem Vagas disponivel') {
                Response::json(['error' => 'Profissão Sem Vagas disponivel'], StatusCode::ACCESS_NOT_ALLOWED);
            }else{
                Response::json(['success' => ['message' => 'Proposta Enviada com sucesso']]);
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

                $prestadores = $this->Evento->getPrestadores($id);
                foreach($prestadores as $evento){
                    $photoEvento = asset("avatar/" . $evento->photo);
                    if ($evento->photo == null) {
                        $photoEvento = null;
                    }
                    $data[]= [
                        'prestadorInfo' => $evento->prestadorInfo,
                        'professions' => $evento->professions,
                        'localidade' => $evento->localidade,
                        'photo' => $photoEvento,
                    ];
                }
                Response::json(['prestadores' => $data]);
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