<?php

namespace MiniRest\Http\Controllers\Produtos\SubProdutos;

use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\SubProdutos\TamanhoRepository;
use MiniRest\DTO\Produto\TamanhoDTO;
use MiniRest\Actions\Produtos\TamanhoCreateAction;
use MiniRest\Models\Produto\SubProdutos\Tamanho;

class TamanhoController extends Controller
{

    private TamanhoRepository $tamanhoRepository;

    public function __construct( )
    {
        $this->tamanhoRepository = new TamanhoRepository();
    }
    public function index()
    {
        Response::json(['Tamanhos' => $this->tamanhoRepository->getTamanho()]);



    }



    /**
     * @throws \Exception
     */
    public function storeTamanho(Request $request)
    {

        $validation = $request->rules([
            'Tamanho' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        if(Auth::id($request) == 1){


            $tamanhoDTO = new TamanhoDTO($request);
            (new TamanhoCreateAction())->execute($tamanhoDTO);

            Response::json([
                'message'=>'Tamanho criado com sucesso!',
            ], StatusCode::CREATED);



        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }




}