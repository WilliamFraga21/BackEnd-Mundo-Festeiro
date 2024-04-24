<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\Evento;
use Illuminate\Database\Capsule\Manager as DB;
use SoftDeletes;

class EventoRepository
{
    private Evento $evento;

    public function __construct()
    {
        $this->evento = new Evento();
    }

    public function me(int $userId)
    {

        $prestador = $this->evento->select('*')->where('prestador_id', $userId)->get();


        return $prestador;
    }

    public function byid(int $userId)
    {
        return $this->evento->where('profissao_id', $userId)->first();
    } 
    public function dellid(int $userId, $profe)
    {
        $profession =  $this->evento->where('profissao_id',$profe)->where('prestador_id',$userId)->delete();
        
        return $profession;
    }

    
    public function ifdellid(int $userId, $profe)
    {
        return $this->evento->where('profissao_id',$profe)->where('prestador_id',$userId)->first();
    } 
    
    

    /**
     * @throws DatabaseInsertException
     */
    public function store(int $idUser, array $data , int $localidade)
    {

        $evento = $this->evento->create([
            'nomeEvento' => $data['nomeEvento'],
            'tipoEvento' => $data['tipoEvento'],
            'data' => $data['data'],
            'quantidadePessoas' => $data['quantidadePessoas'],
            'quantidadeFuncionarios' => $data['quantidadeFuncionarios'],
            'statusEvento' => $data['statusEvento'],
            'descricaoEvento' => $data['descricaoEvento'],
            'users_id' => $idUser,
            'localidade_id' => $localidade,
        ]);

        return $evento->id;
        
    }

    public function updateProfesionPrestador( array $data,int $prestadorId)
    {
        return $this->evento
            ->where('prestador_id', $prestadorId)->where('profissao_id',$data['profissao_id'])
            ->update(
                
                [
                    'valorDiaServicoProfissao' => $data['valorDiaServicoProfissao'],
                    'valorHoraServicoProfissao' => $data['valorHoraServicoProfissao']
                ]
            );
    }

    
}
