<?php

namespace MiniRest\Http\Controllers\Produtos;

use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\Produtos\ProdutosVariacoesRepository;
use MiniRest\DTO\Produto\ProdutosVariacoesDTO;
use MiniRest\DTO\Produto\ProdutosVariacoesUpdateDTO;
use MiniRest\Actions\Produtos\ProdutosVariacoesCreateAction;
use MiniRest\Actions\Produtos\ProdutosVariacoesUpdateAction;

class ProdutosVariacoesController extends Controller
{


    private ProdutosVariacoesRepository $produtosVariacoesRepository;

    public function __construct( )
    {
        $this->produtosVariacoesRepository = new ProdutosVariacoesRepository();
    }


    public function index()
    {

        Response::json(['Produtos' => $this->produtosVariacoesRepository->getProdutos()]);
    }
    public function indexSubCat(int $id)
    {

        Response::json(['Produtos' => $this->produtosVariacoesRepository->getProdutosSubCat($id)]);
    }
    public function indexCat(int $id)
    {

        Response::json(['Produtos' => $this->produtosVariacoesRepository->getProdutosCat($id)]);
    }





    /**
     * @throws \Exception
     */
    public function storeProdutoVari(Request $request)
    {

        $validation = $request->rules([
            'Valor' => 'required',
            'cores_id' => 'required',
            'tamanho_id' => 'required',
            'produtos_id' => 'required',
            'QuantidadeEstoque' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        if (Auth::id($request) == 1){


            $produtoDTO = new ProdutosVariacoesDTO($request);
            (new ProdutosVariacoesCreateAction())->execute($produtoDTO);

            Response::json([
                'message'=>'Produto(Variação) criado com sucesso!',
            ], StatusCode::CREATED);
        }else{

            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }



    }


    public function updateProdutoVari(Request $request)
    {

        $validation = $request->rules([
            'Valor' => 'required',
            'produtos_id' => 'required',
            'QuantidadeEstoque' => 'required',
            'estoque_id' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        if (Auth::id($request) == 1){


            $produtoDTO = new ProdutosVariacoesUpdateDTO($request);
            (new ProdutosVariacoesUpdateAction())->execute($produtoDTO);

            Response::json([
                'message'=>'Produto(Variação) Atualizado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }



}