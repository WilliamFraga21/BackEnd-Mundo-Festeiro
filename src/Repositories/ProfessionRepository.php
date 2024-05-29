<?php

namespace MiniRest\Repositories;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\Models\Profession\Profession;

class ProfessionRepository
{
    private Profession $pofissoes;

    public function __construct()
    {
        $this->pofissoes = new Profession();
    }

    public function getAll()
    {
        $profissao = $this->pofissoes->select('id', 'profissao as name','iconURL')->get();

    
        return $profissao;
    }

}
