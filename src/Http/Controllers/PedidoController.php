<?php

namespace MiniRest\Http\Controllers;

use MiniRest\Actions\Produtos\ItensCarrinhoCreateAction;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\ItensCarrinhoRepository;
use MiniRest\Repositories\PedidoRepository;
use MiniRest\DTO\Produto\ItensCarrinhoCreateDTO;

class PedidoController extends Controller
{

    private ItensCarrinhoRepository $carrinhoRepository;
    private PedidoRepository $pedidoRepository;

    public function __construct( )
    {
        $this->pedidoRepository = new PedidoRepository();
        $this->carrinhoRepository = new ItensCarrinhoRepository();
    }






    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {


        $pedido = $this->pedidoRepository->store(Auth::id($request));

        Response::json([
            'message'=>'Pedido Criado com sucesso!','PedidoID' => $pedido
        ], StatusCode::CREATED);

    }






    public function index (Request $request)
    {


        Response::json([ 'Pedido' => $this->pedidoRepository->get(Auth::id($request))]);



    }
    public function indexadmin (Request $request)
    {

        if (Auth::id($request) == 1){


            Response::json([ 'Pedido' => $this->pedidoRepository->getadmin()]);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }





    }




}