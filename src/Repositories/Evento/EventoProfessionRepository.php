<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\EventoProfession;
use Illuminate\Database\Capsule\Manager as DB;
use SoftDeletes;

class EventoProfessionRepository
{
    private EventoProfession $ProfessionEvento;

    public function __construct()
    {
        $this->ProfessionEvento = new EventoProfession();
    }

    public function me(int $userId)
    {

        $prestador = $this->ProfessionEvento->select('*')->where('prestador_id', $userId)->get();


        return $prestador;
    }

    public function byid(int $userId)
    {
        return $this->ProfessionEvento->where('profissao_id', $userId)->first();
    } 
    public function dellid(int $userId, $profe)
    {
        $profession =  $this->ProfessionEvento->where('profissao_id',$profe)->where('prestador_id',$userId)->delete();
        
        return $profession;
    }

    
    public function ifdellid(int $userId, $profe)
    {
        return $this->ProfessionEvento->where('profissao_id',$profe)->where('prestador_id',$userId)->first();
    } 
    
    

    /**
     * @throws DatabaseInsertException
     */
    public function store( int $data ,int $idEvento)
    {
        $evento = $this->ProfessionEvento->create([
            'evento_id' => $idEvento,
            'profissao_id' => $data,
        ]);
        
        return $evento->id;
        
    }

    public function updateProfesionPrestador( array $data,int $prestadorId)
    {
        return $this->ProfessionEvento
            ->where('prestador_id', $prestadorId)->where('profissao_id',$data['profissao_id'])
            ->update(
                
                [
                    'valorDiaServicoProfissao' => $data['valorDiaServicoProfissao'],
                    'valorHoraServicoProfissao' => $data['valorHoraServicoProfissao']
                ]
            );
    }

    
}
