<?php
// Controller: ProdutoController.php
namespace App\Http\Controllers\Produtos;

use MiniRest\DTO\Produto\ProdutoFiltroDTO;
use MiniRest\Repositories\Produtos;

use Illuminate\Http\Request;

class ProdutoFiltroController extends Controller
{
    protected $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index(Request $request)
    {
        // Criando o DTO com os filtros da requisição
        $filtros = new ProdutoFilterDTO(
            $request->input('cor'),
            $request->input('categoria'),
            $request->input('preco_min'),
            $request->input('preco_max')
        );

        // Chamando o repositório para filtrar os produtos
        $produtos = $this->produtoRepository->filtrarProdutos($filtros);

        return response()->json($produtos);
    }
}
