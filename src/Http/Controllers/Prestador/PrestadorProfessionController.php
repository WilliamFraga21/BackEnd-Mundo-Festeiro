<?php

namespace MiniRest\Http\Controllers\Prestador;

use Exception;
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
use RuntimeException;

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
                $idPrestador = $this->prestador->meProfession(Auth::id($request));
                // dd($idPrestador);

                if ($idPrestador == null) {
                    Response::json(['error' => 'Evento não tem Profissão cadastrada até o momento!'],  StatusCode::ACCESS_NOT_ALLOWED);
                }else{
                    
                    Response::json(['prestador' => $this->prestadorPrefesion->me($idPrestador->id)]);
                }



        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Prestador Não tem Profissão até o momento!!', $exception->getMessage()], StatusCode::ACCESS_NOT_ALLOWED);
        }
    }

    public function delete(Request $request,int $idprofession)
    {

        $idPrestador = $this->prestador->meProfession(Auth::id($request));

        if (!$idPrestador) {
            Response::json(['error' => 'Usuário não cadastrado como prestador'], StatusCode::ACCESS_NOT_ALLOWED);
            return;
        }
        if ($this->prestadorPrefesion->ifdellid($idPrestador->id,$idprofession) == null ) {
            Response::json(['error' => 'Profissão já deletada ou nenhuma profissão encontrada'], StatusCode::ACCESS_NOT_ALLOWED);
            return;
        }
        Response::json(['Profissão Deletada:' => $this->prestadorPrefesion->dellid($idPrestador->id,$idprofession)]);   
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
                    
                $idPrestador = $this->prestador->meProfession(Auth::id($request));
                if ($idPrestador == null) {
                    Response::json(['error' => 'Pretador Não cadastrado ou nenhuma profissão cadastrada até o momento'],  StatusCode::ACCESS_NOT_ALLOWED);
                }else{
    
                $prestadorId = (new PrestadorProfessionCreateAction())->execute(
                    new PrestadorProfessionCreateDTO($request),
                    $idPrestador->id
                );
                Response::json(['success' => ['message' => 'Profissao Prestador cadastrado com sucesso']]);
                }
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
            $idPrestador = $this->prestador->meProfession(Auth::id($request));

            if ($idPrestador == null) {
                Response::json(['error' => 'Pretador Não cadastrado ou nenhuma profissão cadastrada até o momento'],  StatusCode::ACCESS_NOT_ALLOWED);
            }else{
                (new PrestadorProfessionUpdateAction())->execute(
        
                    new PrestadorProfessionCreateDTO($request),
                    $idPrestador->id
                );
                Response::json(['success' => ['message' => 'Profissão atualizada com sucesso']]);
            }
        } catch (ModelNotFoundException $exception) {
            Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::ACCESS_NOT_ALLOWED);
        }

        


    }
}