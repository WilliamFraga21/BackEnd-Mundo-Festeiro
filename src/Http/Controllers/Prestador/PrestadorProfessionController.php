<?php

namespace MiniRest\Http\Controllers\Prestador;

use MiniRest\Actions\Prestador\PrestadorCreateAction;
use MiniRest\Actions\Prestador\PrestadorProfessionUpdateAction;
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

class PrestadorProfessionController extends Controller
{
    private PrestadorRepository $prestador;
    private PrestadorProfesionRepository $prestadorPrefesion;

    public function __construct()
    {
        $this->prestador = new PrestadorRepository();
        $this->prestadorPrefesion = new PrestadorProfesionRepository();
    }



    public function me(Request $request)
    {
        try {
            try {
                $idPrestador = $this->prestador->me(Auth::id($request));
                
            } catch (ModelNotFoundException $exception) {
                // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
            }
            Response::json(['prestador' => $this->prestadorPrefesion->me($idPrestador->id)]);
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Prestador Não tem Profissão até o momento!!', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }

    public function delete(Request $request,$idprofession)
    {
    
        try {
            try {
                $idPrestador = $this->prestador->me(Auth::id($request));
                
            } catch (ModelNotFoundException $exception) {
                Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
            }
            Response::json(['Profissão Deletada:' ,$this->prestadorPrefesion->dellid($idPrestador->id,$idprofession)]);
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Prestador Não tem Profissão até o momento!!', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }



    public function store(Request $request)
    {
        $validation = $request->rules([
            'profession' => 'required|array',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }
        
        try {
            try {
                $idPrestador = $this->prestador->me(Auth::id($request));
                
            } catch (ModelNotFoundException $exception) {
                // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
            }
            $prestadorId = (new PrestadorProfessionCreateAction())->execute(

                new PrestadorProfessionCreateDTO($request),
                $idPrestador->id
            );

            Response::json(['success' => ['message' => 'Profissao Prestador cadastrado com sucesso']]);
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }


    }

    public function update(Request $request)
    {
        $validation = $request->rules([
            'profession' => 'required|array',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        try {
            $idPrestador = $this->prestador->me(Auth::id($request));
            (new PrestadorProfessionUpdateAction())->execute(
    
                new PrestadorProfessionCreateDTO($request),
                $idPrestador->id
            );
            Response::json(['success' => ['message' => 'Profissão atualizada com sucesso']]);
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }

        


    }
}