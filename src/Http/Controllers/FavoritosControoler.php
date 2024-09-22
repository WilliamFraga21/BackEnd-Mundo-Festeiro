<?php

namespace MiniRest\Http\Controllers;

use MiniRest\Actions\Produtos\FavoritosCreateAction;
use MiniRest\DTO\Produto\ProdutoUpdateDTO;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\FavoritosRepository;
use MiniRest\DTO\Produto\ProdutosDTO;
use MiniRest\Actions\Produtos\ProdutosCreateAction;
use MiniRest\Models\Produto\Produto\Produtos;

class FavoritosControoler extends Controller
{

    private FavoritosRepository $favoritosRepository;

    public function __construct( )
    {
        $this->favoritosRepository = new FavoritosRepository();
    }






    /**
     * @throws \Exception
     */
    public function storeFavoritos(Request $request,int $idProduto)
    {




        $favorito = (new FavoritosCreateAction())->execute($idProduto,Auth::id($request));


        if ($favorito == 'Produto não encontrado'){

            Response::json(['error' => 'Produto não encontrado'], StatusCode::REQUEST_ERROR);
        }else{
            Response::json([
                'message'=>'Produto Favoritado com sucesso!',
            ], StatusCode::CREATED);

        }

    }


    public function delete(Request $request,int $item)
    {



            $itemDeletado = $this->favoritosRepository->dellid($item,Auth::id($request));


            if ($itemDeletado == 'Produto não encontrado'){
                Response::json(['error' => 'Produto não encontrado'], StatusCode::REQUEST_ERROR);
            }else{


                Response::json([
                    'message'=>'Produto Deletado com sucesso!',
                ], StatusCode::CREATED);
            }


    }
    public function index(Request $request)
    {


        Response::json(['Favoritos' => $this->favoritosRepository->get(Auth::id($request))]);



    }




}