<?php

namespace MiniRest\Http\Controllers\Produtos\SubProdutos;

use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\SubProdutos\CoresRepository;
use MiniRest\DTO\Produto\CoresDTO;
use MiniRest\Actions\Produtos\CoresCreateAction;
use MiniRest\Models\Produto\SubProdutos\Cores;

class CoresController extends Controller
{



    private CoresRepository $coresRepository;

    public function __construct( )
    {
        $this->coresRepository = new CoresRepository();
    }
    public function index()
    {
        Response::json(['Cores' => $this->coresRepository->getCores()]);



    }



    /**
     * @throws \Exception
     */
    public function storeCores(Request $request)
    {

        $validation = $request->rules([
            'Cor' => 'required',
            'Codigo_Cor' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }



        if(Auth::id($request) == 1){


            $tamanhoDTO = new CoresDTO($request);
            (new CoresCreateAction())->execute($tamanhoDTO);

            Response::json([
                'message'=>'Cor criada com sucesso!',
            ], StatusCode::CREATED);

        }else{


            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }




}