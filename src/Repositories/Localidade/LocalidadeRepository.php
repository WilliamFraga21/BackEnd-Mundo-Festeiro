<?php

namespace MiniRest\Repositories\Localidade;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Localidade\Localidade;
use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\Models\Prestador\PrestadorApresentacao;
use MiniRest\Models\Prestador\PrestadorHabilidades;
use MiniRest\Models\Prestador\PrestadorProfissao;

class LocalidadeRepository
{
    private Localidade $localidade;

    public function __construct()
    {
        $this->localidade = new Localidade();
    }

    /**
     * @throws DatabaseInsertException
     */
    public function storeLocalidade( array $data)
    {
        $id = $this->localidade
            ->firstOrCreate(
                [
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'cidade' => $data['cidade'],
                    'estado' => $data['estado'],
                ]
            );

        
        return $id->id;


    }





}