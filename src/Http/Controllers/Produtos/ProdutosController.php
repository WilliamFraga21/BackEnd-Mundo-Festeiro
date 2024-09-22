<?php

namespace MiniRest\Http\Controllers\Produtos;

use MiniRest\Actions\Produtos\ProdutoUpdateAction;
use MiniRest\DTO\Produto\ProdutoUpdateDTO;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\SubProdutos\TamanhoRepository;
use MiniRest\DTO\Produto\ProdutosDTO;
use MiniRest\Actions\Produtos\ProdutosCreateAction;
use MiniRest\Models\Produto\Produto\Produtos;

class ProdutosController extends Controller
{

    public function index()
    {
        Response::json(['Tamanhos' => Produtos::query()]);



    }



    /**
     * @throws \Exception
     */
    public function storeProduto(Request $request)
    {

        $validation = $request->rules([
            'Nome_Produto' => 'required',
            'Descricao' => 'required',
            'categorias_id' => 'required',
            'subcategorias_id' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        if(Auth::id($request) == 1){


            $produtoDTO = new ProdutosDTO($request);
            (new ProdutosCreateAction())->execute($produtoDTO);

            Response::json([
                'message'=>'Produto criado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }


    public function updateProduto(Request $request)
    {

        $validation = $request->rules([
            'Nome_Produto' => 'required',
            'Descricao' => 'required',
            'ProdutoID' => 'required',
            'subcategorias_id' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        if(Auth::id($request) == 1){


            $produtoDTO = new ProdutoUpdateDTO($request);
            (new ProdutoUpdateAction())->execute($produtoDTO);

            Response::json([
                'message'=>'Produto Atualizado com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }



    }




}