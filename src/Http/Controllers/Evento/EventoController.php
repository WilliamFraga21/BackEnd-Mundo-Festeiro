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
use MiniRest\Repositories\Evento\EventoProfesionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;

class EventoController extends Controller
{
    private EventoRepository $Evento;

    public function __construct()
    {
        $this->Evento = new EventoRepository();
    }

    public function index()
    {   
        // Response::json(['prestador' => $this->Evento->getAll()]);
    }

    public function findById(int $id)
    {
        // try {
        //     Response::json(['prestador' => $this->Evento->find($id)]);
        // } catch (PrestadorNotFoundException $e) {
        //     Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
        // }
    }

    public function me(Request $request)
    {
        try {
            Response::json(['prestador' => $this->Evento->me(Auth::id($request))]);
        } catch (ModelNotFoundException $exception) {
            // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
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

    

    public function update(Request $request)
    {
        $validation = $request->rules([
            'promotorEvento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        (new EventoUpdateAction())->execute(
            Auth::id($request),
            new EventoCreateDTO($request)
        );

        Response::json(['success' => ['message' => 'prestador atualizado com sucesso']]);

    }
}