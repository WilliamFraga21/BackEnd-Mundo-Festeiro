<?php

namespace MiniRest\Http\Controllers\Produtos;

use MiniRest\Actions\Produtos\PagamentoCreateAction;
use MiniRest\Actions\Produtos\CupomCreateAction;
use MiniRest\DTO\Produto\PagamentosDTO;
use MiniRest\DTO\Produto\CupomDTO;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\PagamentoRepository;
use MiniRest\DTO\Produto\ProdutosDTO;
use MiniRest\Actions\Produtos\ProdutosCreateAction;
use MiniRest\Models\Produto\Produto\Produtos;

class PagamentoController extends Controller
{

    private PagamentoRepository $pagamentoRepository;

    public function __construct(){
        $this->pagamentoRepository = new PagamentoRepository();
    }
    public function index()
    {
        Response::json(['Tamanhos' => Produtos::query()]);



    }



    /**
     * @throws \Exception
     */
    public function storePagamento(Request $request)
    {



        $validation = $request->rules([
            'Valor' => 'required',
            'Metodo_Pagamento' => 'required',
            'Data_Pagamento' => 'required',
            'pedido_id' => 'required',
            'pedido_users_id' => 'required',
            'localidade_id' => 'required',
            'cupom_id' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        if(Auth::id($request) == 1){


            $pagamentoDTO = new PagamentosDTO($request);
            (new PagamentoCreateAction())->execute($pagamentoDTO,Auth::id($request));

            Response::json([
                'message'=>'Pagamento criado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }

    public function storeCupom(Request $request)
    {



        $validation = $request->rules([
            'Codigo' => 'required',
            'Tempo' => 'required',
            'Status' => 'required',


        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        if(Auth::id($request) == 1){


            $cupomDTO = new CupomDTO($request);
            (new CupomCreateAction())->execute($cupomDTO);

            Response::json([
                'message'=>'Cupom criado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }


    public function updateStatus(Request $request,$idPagamento,$status)
    {



        if(Auth::id($request) == 1){


            $this->pagamentoRepository->updateStatus($idPagamento,$status);

            Response::json([
                'message'=>'Status Atualizado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }



    }




}