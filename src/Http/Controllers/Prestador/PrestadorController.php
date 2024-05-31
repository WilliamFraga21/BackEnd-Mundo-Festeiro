<?php

namespace MiniRest\Http\Controllers\Prestador;

use MiniRest\Actions\Prestador\ContratarPrestadorCreateAction;
use MiniRest\Actions\Prestador\PrestadorCreateAction;
use MiniRest\Actions\Prestador\PrestadorUpdateAction;
use MiniRest\Actions\Prestador\PrestadorAceitarUpdateAction;
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
use MiniRest\Repositories\AvatarRepository;
class PrestadorController extends Controller
{
    private PrestadorRepository $prestador;
    private PrestadorProfesionRepository $prestadorPrefesion;

    public function __construct()
    {
        $this->prestador = new PrestadorRepository();
        $this->prestadorPrefesion = new PrestadorProfesionRepository();
    }

    public function index($id)
    {   
        $prestadores = $this->prestador->getAll($id);

        foreach($prestadores as $prestador){
            $photo = (new AvatarRepository())->getUserAvatar($prestador['prestadorInfo']->users_id);
            $photoPrestador = asset("avatar/" . $photo);
            if ($photo == null) {
                $photoPrestador = null;
            }
            $data[]= [
                'prestadorInfo' => $prestador['prestadorInfo'],
                'prestadorprofessions' => $prestador['prestadorprofessions'],
                'infoPrestadorEnd' => $prestador['infoPrestadorEnd'],
                'photo' => $photoPrestador,
            ];
        }
        Response::json(['prestador' => $data]);
    }

    public function findById(int $id)
    {
        try {
            $prestador = $this->prestador->find($id);
            $prestador2 = $this->prestador->find2($id);
            $photo = (new AvatarRepository())->getUserAvatar($prestador2);
            if ($photo == null) {
                Response::json(['prestador' => $prestador,'photo'=> null]);
            }else{
                Response::json(['prestador' => $prestador,'photo'=> asset("avatar/" . $photo)]);
            }


        } catch (PrestadorNotFoundException $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
        }
    }

    public function me(Request $request)
    {
        try {
            $prestador = $this->prestador->me(Auth::id($request));
            $photo = (new AvatarRepository())->getUserAvatar(Auth::id($request));
            if ($photo== null) {
                Response::json(['prestador' => $prestador, 'photo' => null]);
            } else {
                Response::json(['prestador' => $prestador, 'photo' => asset("avatar/" . $photo)]);
            }
            
        } catch (ModelNotFoundException $exception) {
            // Response::json(['error' => 'Usuário não cadastrado como prestador', $exception->getMessage()], StatusCode::SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validation = $request->rules([
            'promotorEvento' => 'required',
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

    public function storeContratar(int $idPrestador,Request $request)
    {
       
        try {

            $prestadorId = (new ContratarPrestadorCreateAction())->execute(
                Auth::id($request),
                $idPrestador
            );
            Response::json(['success' => ['message' => 'Proposta Enviada','proposta:' => $prestadorId]]);
        } catch (DatabaseInsertException $exception) {
            Response::json(['error' => ['message' => $exception->getMessage()]], $exception->getCode());
        }


    }
    public function getPropostas(Request $request)
    {
       
        try {
            if ($this->prestador->getpropostas(Auth::id($request)) == "Prestador não encontrado") {
                Response::json(['error' => 'Você não é um prestador'], StatusCode::ACCESS_NOT_ALLOWED);

            }else{
                $prestador = $this->prestador->getpropostas(Auth::id($request));
                Response::json(['propostas' => $prestador]);


            }
            
            


        } catch (PrestadorNotFoundException $e) {
            Response::json(['error' => ['message' => $e->getMessage()]], $e->getCode());
        }


    }

    

    public function aceietarProposta(Request $request,int $idProposta)
    {
        
        $prestador = (new PrestadorAceitarUpdateAction())->execute(
            Auth::id($request),
            $idProposta
        );

        if ($prestador == 'prestador não encontrado') {
            Response::json(['error' => 'Você não é um prestador'], StatusCode::ACCESS_NOT_ALLOWED);
            
        }else{

            Response::json(['success' => ['message' => 'Proposta aceita com sucesso']]);
        }


    }
    public function update(Request $request)
    {
        $validation = $request->rules([
            'promotorEvento' => 'required',
            'curriculo' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        $prestador = (new PrestadorUpdateAction())->execute(
            Auth::id($request),
            new PrestadorCreateDTO($request)
        );

        if ($prestador == 'prestador não encontrado') {
            Response::json(['error' => 'Você não é um prestador'], StatusCode::ACCESS_NOT_ALLOWED);
            
        }else{

            Response::json(['success' => ['message' => 'prestador atualizado com sucesso']]);
        }


    }
}