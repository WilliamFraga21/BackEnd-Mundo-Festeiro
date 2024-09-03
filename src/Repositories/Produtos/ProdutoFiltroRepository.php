<?php
// Repository: ProdutoRepository.php
namespace MiniRest\Repositories\Produtos;


use MiniRest\Models\Produto\Produto\Produtos;

use MiniRest\DTO\Produto\ProdutoFiltroDTO;


class ProdutoFiltroRepository
{
    public function filtrarProdutos(ProdutoFilterDTO $filtros)
    {
        $query = Produto::query();

        // Aplicando filtros dinamicamente
        if ($filtros->cor) {
            $query->whereHas('variacoes', function ($q) use ($filtros) {
                $q->where('descricao', $filtros->cor);
            });
        }

        if ($filtros->categoria) {
            $query->where('categoria_id', $filtros->categoria);
        }

        if ($filtros->precoMin !== null && $filtros->precoMax !== null) {
            $query->whereBetween('preco', [$filtros->precoMin, $filtros->precoMax]);
        }

        return $query->get();
    }
}
