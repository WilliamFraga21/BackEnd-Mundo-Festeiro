<?php

namespace MiniRest\Http\Controllers\Produtos\SubProdutos;

use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\SubProdutos\TamanhoRepository;
use MiniRest\DTO\Produto\SubCategoriaDTO;
use MiniRest\Actions\Produtos\SubCaregoriaCreateAction;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;

class SubCategoriaController extends Controller
{

    public function index()
    {
        Response::json(['Tamanhos' => SubCategorias::query()]);



    }



    /**
     * @throws \Exception
     */
    public function storeSubCategoria(Request $request)
    {

        $validation = $request->rules([
            'categorias_id' => 'required',
            'SubCategoria' => 'required',
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        $categoriaDTO = new SubCategoriaDTO($request);
        (new SubCaregoriaCreateAction())->execute($categoriaDTO);

        Response::json([
            'message'=>'SubCategoria criada com sucesso!',
        ], StatusCode::CREATED);

    }




}