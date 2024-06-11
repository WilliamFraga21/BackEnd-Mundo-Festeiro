<?php

namespace MiniRest\Repositories;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use Illuminate\Database\Capsule\Manager as DB;  // Importa o Capsule
use MiniRest\Models\Profession\Profession;

class ProfessionRepository
{
    private Profession $profissoes;

    public function __construct()
    {
        $this->profissoes = new Profession();
    }

    public function getAll()
    {
        $profissao = $this->profissoes->select('id', 'profissao as name', 'iconURL')->get();

        return $profissao;
    }

    public function getAllPrestadores()
{
    $profissoes = Profession::select(
            'profissao.id as idProfessionPrestador', 
            'profissao.profissao as name', 
            'profissao.iconURL', 
            DB::raw('count(prestador_has_profissao.profissao_id) as quantidade')
        )
        ->leftJoin('prestador_has_profissao', 'profissao.id', '=', 'prestador_has_profissao.profissao_id')
        ->groupBy('profissao.id', 'profissao.profissao', 'profissao.iconURL')
        ->whereNotNull('prestador_has_profissao.profissao_id') // Filtra apenas profissões com profissao_id correspondente
        ->get();

    return $profissoes;
}


public function getAllEventos()
{
    $profissoes = Profession::select(
            'profissao.id as idProfessionEvento', 
            'profissao.profissao as name', 
            'profissao.iconURL',
            DB::raw('count(evento_has_profissao.profissao_id) as quantidade')
        )
        ->leftJoin('evento_has_profissao', 'profissao.id', '=', 'evento_has_profissao.profissao_id')
        ->groupBy('profissao.id', 'profissao.profissao', 'profissao.iconURL')
        ->whereNotNull('evento_has_profissao.profissao_id')
        ->get();

    return $profissoes;
}

}
