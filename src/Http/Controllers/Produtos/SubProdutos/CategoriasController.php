<?php

namespace MiniRest\Http\Controllers\Produtos\SubProdutos;

use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\SubProdutos\CategoriasRepository;
use MiniRest\DTO\Produto\CategoriasDTO;
use MiniRest\Actions\Produtos\CategoriaCreateAction;
use MiniRest\Models\Produto\SubProdutos\Categorias;
use MiniRest\Models\Produto\SubProdutos\SubCategorias;

class CategoriasController extends Controller
{

    private CategoriasRepository $categoriasRepository;

    public function __construct( )
    {
        $this->categoriasRepository = new CategoriasRepository();
    }

    public function index()
    {


        Response::json(['Categorias' => $this->categoriasRepository->getCategoria()]);



    }



    /**
     * @throws \Exception
     */
    public function storeCategorias(Request $request)
    {
        $validation = $request->rules([
            'Categoria' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        if(Auth::id($request) == 1){

            $categoriaDTO = new CategoriasDTO($request);
            (new CategoriaCreateAction())->execute($categoriaDTO);

            Response::json([
                'message'=>'Categoria criada com sucesso!',
            ], StatusCode::CREATED);


        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }




}