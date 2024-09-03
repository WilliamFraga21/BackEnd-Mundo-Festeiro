<?php

namespace MiniRest\DTO\Produto;

use MiniRest\DTO\DTO;
use MiniRest\Http\Request\Request;

class ProdutoFiltroDTO
{
    public ?string $cor;
    public ?int $categoria;
    public ?float $precoMin;
    public ?float $precoMax;

    public function __construct($cor = null, $categoria = null, $precoMin = null, $precoMax = null)
    {
        $this->cor = $cor;
        $this->categoria = $categoria;
        $this->precoMin = $precoMin;
        $this->precoMax = $precoMax;
    }


}