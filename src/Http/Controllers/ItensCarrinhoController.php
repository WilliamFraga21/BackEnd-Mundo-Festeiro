<?php

namespace MiniRest\Http\Controllers;

use MiniRest\Actions\Produtos\ItensCarrinhoCreateAction;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\ItensCarrinhoRepository;
use MiniRest\DTO\Produto\ItensCarrinhoCreateDTO;

class ItensCarrinhoController extends Controller
{

    private ItensCarrinhoRepository $carrinhoRepository;

    public function __construct( )
    {
        $this->carrinhoRepository = new ItensCarrinhoRepository();
    }

    public function index(Request $request)
    {
        Response::json(['Carrinho' => $this->carrinhoRepository->get(Auth::id($request))]);
    }




    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {


        $validation = $request->rules([
            'Valor_Uni' => 'required',
            'Quantidade' => 'required',
            'produtosvariasoes_id' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }



        $eventoId = (new ItensCarrinhoCreateAction())->execute(
            Auth::id($request),
            new ItensCarrinhoCreateDTO($request)
        );

        Response::json([
            'message'=>'Produto Adicionado ao Carrinho com sucesso!',
        ], StatusCode::CREATED);

    }


    public function delete(Request $request,int $item)
    {

        $itemDeletado = $this->carrinhoRepository->dellid($item,Auth::id($request));


        Response::json([
            'message'=>'Produto Deletado com sucesso!',
        ], StatusCode::CREATED);

    }


    public function menosUmProduto(Request $request,int $item)
    {

        $itemDeletado = $this->carrinhoRepository->DiminuirQuantidade($item,Auth::id($request));


        Response::json([
            'message'=>'Produto -1 com sucesso!',
        ], StatusCode::CREATED);

    }
    public function maisUmProduto(Request $request,int $item)
    {

        $itemDeletado = $this->carrinhoRepository->aumentarQuantidade($item,Auth::id($request));


        Response::json([
            'message'=>'Produto +1 com sucesso!',
        ], StatusCode::CREATED);

    }



    public function quantidadeItensCarrinho(Request $request)
    {

        $itemDeletado = $this->carrinhoRepository->quantidadeItens(Auth::id($request));


        Response::json(['Itens' => $itemDeletado]);





    }


}