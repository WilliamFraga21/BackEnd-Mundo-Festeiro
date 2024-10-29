<?php


namespace MiniRest\Repositories;

use Illuminate\Database\Capsule\Manager as DB;
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

        $informacoes = DB::table('produtosvariasoes')
            ->select(
                'tamanho.id as tamanhoID',
                'estoque.id as estoqueID',
                'cores.id as coresID',
                'subcategorias.id as subcategoriasID',
                'categorias.id as categoriasID',
                'produtos.id as produtosID',
                'produtosvariasoes.id as produtosvariasoesID',
                'Tamanho',
                'estoque.Quantidade as estoqueQuantidade',
                'Cor',
                'Codigo_Cor',
                'cores_id',
                'tamanho_id',
                'Categoria',
                'SubCategoria',
                'Valor',
                'produtos_id',
                'estoque_id',
                'produtosvariasoes.Status as produtosvariasoesStatus',
                'produtos.Status as produtosStatus',
                'Nome_Produto',
                'Descricao',
                'Porcentagem',
                'Tempo'
            )
            ->join('produtos', 'produtosvariasoes.produtos_id', '=', 'produtos.id')
            ->join('subcategorias', 'produtos.subcategorias_id', '=', 'subcategorias.id')
            ->join('categorias', 'produtos.categorias_id', '=', 'categorias.id')
            ->join('cores', 'produtosvariasoes.cores_id', '=', 'cores.id')
            ->join('estoque', 'produtosvariasoes.estoque_id', '=', 'estoque.id')
            ->join('tamanho', 'produtosvariasoes.tamanho_id', '=', 'tamanho.id')
            ->join('promo', 'produtosvariasoes.promo_id', '=', 'promo.id')
            ->join('favoritos', 'favoritos.produtosvariasoes_id', '=', 'produtosvariasoes.id') // Corrigido para referenciar 'favoritos'
            ->where('users_id', $user)
            ->get();


        if ($informacoes->isEmpty()){
            return 'Nenhum Produto com Promoção';
        }else{

            foreach ($informacoes as $data){



                $object = [
                    'Nome_Produto' => $data->Nome_Produto,
                    'ProdutoID' => $data->produtosID,
                    'Descricao' => $data->Descricao,
                    'categorias_id' => $data->categoriasID,
                    'Categoria' => $data->Categoria,
                    'SubCategoria' => $data->SubCategoria,
                    'subcategorias_id' => $data->subcategoriasID,
                    'StatusProduto' => $data->produtosStatus,
                    'idVariacao' => $data->produtosvariasoesID,
                    'Valor' => $data->Valor,
                    'StatusVariacao' => $data->produtosvariasoesStatus,
                    'Cor' => $data->Cor,
                    'Tamanho' => $data->Tamanho,
                    'Estoque' => $data->estoqueQuantidade,
                    'Porcentagem' => $data->Porcentagem,
                    'Tempo' => $data->Tempo,
                    'valorComDesconto' => $data->Valor - ($data->Valor * $data->Porcentagem) / 100,
                    'StatusProdutoVariacao' => $data->produtosvariasoesStatus,


                ];
                $produtoCompleto[] = $object;

            }




            return $produtoCompleto;
        }
    }


}