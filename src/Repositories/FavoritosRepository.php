<?php


namespace MiniRest\Repositories;

use MiniRest\Models\Favoritos;
use MiniRest\Models\Produto\Produto\ProdutosVariasoes;

class FavoritosRepository
{
    private Favoritos $favoritos;
    private ProdutosVariasoes $produtosVariasoes;

    public function __construct()
    {
        $this->favoritos = new Favoritos();
        $this->produtosVariasoes = new ProdutosVariasoes();
    }

    public function store(int $idProduto,int $idUser)
    {

        $validation = $this->produtosVariasoes->where('id',$idProduto)->first();
        if ($validation == null){
            return 'Produto não encontrado';
        }else{


            $id = $this->favoritos
                ->firstOrCreate(
                    [
                        'users_id' => $idUser,
                        'produtosvariasoes_id' => $idProduto,
                    ],
                    [
                        'users_id' => $idUser,
                        'produtosvariasoes_id' => $idProduto,
                    ]
                );

            return $id->id;
        }



    }

    public function dellid(int $id,int $user)
    {

        $validation = $this->favoritos->where('id',$id)->first();
        if ($validation == null){
            return 'Produto não encontrado';
        }else{

            $intelFavorito =  $this->favoritos->where('id',$id)->where('users_id',$user)->delete();

            return $intelFavorito;
        }



    }
    public function get(int $user)
    {

        $intelFavorito =  $this->favoritos->where('users_id',$user)->get();

        return $intelFavorito;
    }


}