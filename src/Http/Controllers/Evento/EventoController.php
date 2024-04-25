<?php

namespace MiniRest\Http\Controllers\Evento;

use MiniRest\Actions\Evento\EventoCreateAction;
use MiniRest\Actions\Evento\EventoUpdateAction;
use MiniRest\DTO\Evento\EventoCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\RuleNotFound;
use MiniRest\Exceptions\InvalidJsonResponseException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\Evento\EventoRepository;
use MiniRest\Repositories\Evento\EventoProfessionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\EventoProfession;

class EventoController extends Controller
{
    private EventoRepository $Evento;
    private EventoProfessionRepository $EventoProfession;

    public function __construct()
    {
        $this->Evento = new EventoRepository();
        $this->EventoProfession = new EventoProfessionRepository();
    }

    public function index()
    {   
        // Response::json(['prestador' => $this->Evento->getAll()]);
    }

    public function findById(int $id)
    {
        try {
            Response::json(['Evento' => $this->Evento->find($id)]);
        } catch (\Exception $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
        }
    }

    public function me(Request $request)
    {
        try {

            $dateEvento = $this->Evento->me(Auth::id($request));

            // dd($dateEvento);


            Response::json(['Evento' => $this->Evento->me(Auth::id($request))]);
        } catch (ModelNotFoundException $exception) {
            // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }

    public function deletePro(Request $request,$idProf)
    {
        try {
            $idUser = Auth::id($request);
            if ($this->EventoProfession->ifdellidPro((int)$idProf,$idUser) == NULL) {
                Response::json(['error' => 'Você não pode deletar ou alterar Profissões de eventos de outros usuarios!!'], StatusCode::SERVER_ERROR);
                return;
            }
            if ($this->EventoProfession->ifdellidPro((int)$idProf,$idUser) == 'ja deletada') {
                Response::json(['error' => 'Profissão já deletada'], StatusCode::SERVER_ERROR);
                return;
            }

            // dd($this->EventoProfession->ifdellidPro((int)$idEvento,$idUser));
            Response::json(['success' => 'Profissão deletada',$this->EventoProfession->dellidPro((int)$idProf,(int)$idProf)]);
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }
    public function delete(Request $request,$idEvent)
    {
        try {
            $idUser = Auth::id($request);
            if ($this->Evento->ifdellid($idUser,(int)$idEvent) == NULL) {
                Response::json(['error' => 'Você não pode deletar ou alterar eventos de outros usuarios!!'], StatusCode::SERVER_ERROR);
                return;
            }
            if ($this->Evento->ifdellid($idUser,(int)$idEvent) == 'ja deletado') {
                Response::json(['error' => 'Evento já deletado'], StatusCode::SERVER_ERROR);
                return;
            }

            // dd($this->EventoProfession->ifdellidPro((int)$idEvento,$idUser));
            Response::json(['success' => 'Evento deletado',$this->Evento->dellid((int)$idEvent)]);
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {   
        $validation = $request->rules([
            'nomeEvento' => 'required',
            'tipoEvento' => 'required',
            'data' => 'required',
            'quantidadePessoas' => 'required',
            'quantidadeFuncionarios' => 'required',
            'statusEvento' => 'required',
            'descricaoEvento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'professions' => 'required|array:int',
            ])->validate();
            
        if (!$validation) {
            $request->errors();
            return;
        }
        try {
            $eventoId = (new EventoCreateAction())->execute(
                Auth::id($request),
                new EventoCreateDTO($request)
            );
            Response::json(['success' => ['message' => 'Evento cadastrado com sucesso','EventoId' => $eventoId]]);
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }


    }

    

    public function update(Request $request, $id)
    {
        $validation = $request->rules([
            'nomeEvento' => 'required',
            'tipoEvento' => 'required',
            'data' => 'required',
            'quantidadePessoas' => 'required',
            'quantidadeFuncionarios' => 'required',
            'statusEvento' => 'required',
            'descricaoEvento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'professions' => 'required|array:int',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        $idUser = Auth::id($request);
        // dd($this->Evento->ifdellid($idUser,(int)$id));
        if ($this->Evento->ifdellid($idUser,(int)$id) == NULL) {
            Response::json(['error' => 'Você não pode deletar ou alterar eventos de outros usuarios!!'], StatusCode::SERVER_ERROR);
            return;
        }

            

        (new EventoUpdateAction())->execute(
            Auth::id($request),
            new EventoCreateDTO($request),
            $id
        );

        Response::json(['success' => ['message' => 'Evento atualizado com sucesso']]);

    }
}