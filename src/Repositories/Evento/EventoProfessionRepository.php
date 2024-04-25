<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\EventoProfession;
use MiniRest\Models\Evento\Evento;
use Illuminate\Database\Capsule\Manager as DB;
use SoftDeletes;

use function PHPUnit\Framework\isNull;

class EventoProfessionRepository
{
    private EventoProfession $ProfessionEvento;
    private Evento $Evento;

    public function __construct()
    {
        $this->ProfessionEvento = new EventoProfession();
        $this->Evento = new Evento();
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
    public function dellidPro( $id)
    {
        if (isNull($this->ProfessionEvento->where('id',$id)->delete())) {
            return 'ja deletada';
        }

        $profession =  $this->ProfessionEvento->where('id',$id)->delete();
        
        return $profession;
    }

    
    public function ifdellid(int $userId, $profe)
    {
        return $this->ProfessionEvento->where('profissao_id',$profe)->where('prestador_id',$userId)->first();
    } 

    public function ifdellidPro(int $id, int $idUser)
    {   

        
        if (is_null($this->ProfessionEvento->select('evento_id')->where('id',$id)->first())) {
            return 'ja deletada';
        }
        $idprofession = $this->ProfessionEvento->select('evento_id')->where('id',$id)->first();
        return $this->Evento->where('users_id',$idUser)->where('id',$idprofession->evento_id)->first();
    } 
    
    
    

    /**
     * @throws DatabaseInsertException
     */
    public function store( int $data ,int $idEvento)
    {
        $evento = $this->ProfessionEvento->firstOrCreate([
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
