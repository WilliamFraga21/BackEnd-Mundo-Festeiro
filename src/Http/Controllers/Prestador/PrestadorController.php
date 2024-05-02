<?php

namespace MiniRest\Http\Controllers\Prestador;

use MiniRest\Actions\Prestador\PrestadorCreateAction;
use MiniRest\Actions\Prestador\PrestadorUpdateAction;
use MiniRest\DTO\Prestador\PrestadorCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\InvalidJsonResponseException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\Prestador\PrestadorRepository;
use MiniRest\Repositories\Prestador\PrestadorProfesionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MiniRest\Actions\Prestador\PrestadorProfessionCreateAction;
use MiniRest\DTO\Prestador\PrestadorProfessionCreateDTO;
use MiniRest\Helpers\StatusCode\StatusCode;

class PrestadorController extends Controller
{
    private PrestadorRepository $prestador;
    private PrestadorProfesionRepository $prestadorPrefesion;

    public function __construct()
    {
        $this->prestador = new PrestadorRepository();
        $this->prestadorPrefesion = new PrestadorProfesionRepository();
    }

    public function index()
    {   
        Response::json(['prestador' => $this->prestador->getAll()]);
    }

    public function findById(int $id)
    {
        try {
            
            Response::json(['prestador' => $this->prestador->find($id)]);


        } catch (PrestadorNotFoundException $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
        }
    }

    public function me(Request $request)
    {
        try {
            Response::json(['prestador' => $this->prestador->me(Auth::id($request))]);
        } catch (ModelNotFoundException $exception) {
            // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validation = $request->rules([
            'promotorEvento' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'curriculo' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }
        try {

            $prestadorId = (new PrestadorCreateAction())->execute(
                Auth::id($request),
                new PrestadorCreateDTO($request)
            );
            Response::json(['success' => ['message' => 'prestador cadastrado com sucesso','prestadorId' => $prestadorId]]);
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
            'curriculo' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        (new PrestadorUpdateAction())->execute(
            Auth::id($request),
            new PrestadorCreateDTO($request)
        );

        Response::json(['success' => ['message' => 'prestador atualizado com sucesso']]);

    }
}