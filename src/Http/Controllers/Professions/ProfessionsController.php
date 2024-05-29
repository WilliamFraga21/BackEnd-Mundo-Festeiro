<?php

namespace MiniRest\Http\Controllers\Professions;

use MiniRest\Http\Response\Response;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Repositories\ProfessionRepository;

class ProfessionsController extends Controller
{
    private ProfessionRepository $profissao;

    public function __construct()
    {
        $this->profissao = new ProfessionRepository();
    }

    public function index()
    {
        Response::json([$this->profissao->getAll()]);
    }
    public function index2()
    {
        Response::json(['professions' => $this->profissao->getAll()]);
    }
}
