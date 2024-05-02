<?php

namespace MiniRest\Repositories\Prestador;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\PrestadorProfissao;
use Illuminate\Database\Capsule\Manager as DB;
use SoftDeletes;

class PrestadorProfesionRepository
{
    private PrestadorProfissao $prestadorProfesion;

    public function __construct()
    {
        $this->prestadorProfesion = new PrestadorProfissao();
    }

    public function me(int $userId)
    {

        $prestador = $this->prestadorProfesion->select('*')->where('prestador_id', $userId)->get();

        

        return $prestador;
    }

    public function byid(int $userId)
    {
        return $this->prestadorProfesion->where('profissao_id', $userId)->first();
    } 
    public function dellid(int $userId, $profe)
    {
        $profession =  $this->prestadorProfesion->where('profissao_id',$profe)->where('prestador_id',$userId)->delete();
        
        return $profession;
    }

    
    public function ifdellid(int $userId, $profe)
    {
        return $this->prestadorProfesion->where('profissao_id',$profe)->where('prestador_id',$userId)->first();
    } 
    
    

    /**
     * @throws DatabaseInsertException
     */
    public function store(array $data ,int $idPrestador)
    {

        
        
        
        if ($this->byid($data['profissao_id'])) {
            throw new DatabaseInsertException(
                'error ao fazer o insert, Profissão do prestador já foi cadastrado.',
                StatusCode::NOT_FOUND
            );
        }
        

        $id = $this->prestadorProfesion
            ->firstOrCreate(
                [
                    'prestador_id' => $idPrestador,
                    'profissao_id' => $data['profissao_id'],
                    'tempoexperiencia' => $data['tempoexperiencia'],
                    'valorDiaServicoProfissao' => $data['valorDiaServicoProfissao'],
                    'valorHoraServicoProfissao' => $data['valorHoraServicoProfissao'],
                ]
            );
            return $id->id;

        
    }

    public function updateProfesionPrestador( array $data,int $prestadorId)
    {
        return $this->prestadorProfesion
            ->where('prestador_id', $prestadorId)->where('profissao_id',$data['profissao_id'])
            ->update(
                
                [
                    'valorDiaServicoProfissao' => $data['valorDiaServicoProfissao'],
                    'tempoexperiencia' => $data['tempoexperiencia'],
                    'valorHoraServicoProfissao' => $data['valorHoraServicoProfissao']
                ]
            );
    }

    
}
