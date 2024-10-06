<?php

namespace MiniRest\Http\Controllers\Produtos;

use MiniRest\Actions\Produtos\PromoAddPromoAction;
use MiniRest\DTO\Produto\AddPromoDTO;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Repositories\Produtos\ProdutosVariacoesRepository;
use MiniRest\DTO\Produto\ProdutosVariacoesUpdateDTO;
use MiniRest\Actions\Produtos\ProdutosVariacoesUpdateAction;




use MiniRest\Repositories\Produtos\PromoRepository;
use MiniRest\DTO\Produto\PromoDTO;
use MiniRest\Actions\Produtos\PromoCreateAction;
class PromoController extends Controller
{


    private ProdutosVariacoesRepository $produtosVariacoesRepository;
    private PromoRepository $promoRepository;

    public function __construct( )
    {
        $this->promoRepository = new PromoRepository();
        $this->produtosVariacoesRepository = new ProdutosVariacoesRepository();
    }



    public function desativarPromo(int $id)
    {


        $this->promoRepository->updatePromoDesativar($id);
        Response::json(['Promoção Removida com sucesso'] );
    }

    public function getPromo()
    {


        $data = $this->promoRepository->indexPromo();

        if ($data == 'Nenhuma Promoção encontrada'){
            Response::json(['error' => $data], StatusCode::ACCESS_NOT_ALLOWED);

        }else{

            Response::json(['Promo' => $data]);
        }
    }



    /**
     * @throws \Exception
     */
    public function storePromo(Request $request)
    {

        $validation = $request->rules([
            'Porcentagem' => 'required',
            'Tempo' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        if (Auth::id($request) == 1){


            $promoDTO = new PromoDTO($request);
            (new PromoCreateAction())->execute($promoDTO);

            Response::json([
                'message'=>'Promoção adicionado ao Produto com sucesso!',
            ], StatusCode::CREATED);
        }else{

            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }



    }


    public function addProdutoPromo(Request $request)
    {

        $validation = $request->rules([
            'idpromo' => 'required',
            'id' => 'required',


        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        if (Auth::id($request) == 1){


            $produtoDTO = new AddPromoDTO($request);
            (new PromoAddPromoAction())->execute($produtoDTO);

            Response::json([
                'message'=>'Promoção adicionada com sucesso!',
            ], StatusCode::CREATED);
        }else{
            Response::json(['error' => 'Você não é ADM do sistema'], StatusCode::ACCESS_NOT_ALLOWED);
        }


    }



}