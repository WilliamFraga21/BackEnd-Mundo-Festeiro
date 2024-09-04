<?php


namespace MiniRest\Repositories;

use MiniRest\Models\Favoritos;

class FavoritosRepository
{
    private Favoritos $favoritos;

    public function __construct()
    {
        $this->favoritos = new Favoritos();
    }

    public function store(int $idProduto,int $idUser)
    {

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

    public function dellid(int $id,int $user)
    {

        $intelFavorito =  $this->favoritos->where('id',$id)->where('users_id',$user)->delete();

        return $intelFavorito;
    }
    public function get(int $user)
    {

        $intelFavorito =  $this->favoritos->where('users_id',$user)->get();

        return $intelFavorito;
    }


}