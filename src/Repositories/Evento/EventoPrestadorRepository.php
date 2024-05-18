<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Evento\EventoPrestador;
use MiniRest\Models\Evento\Evento;
use SoftDeletes;

class EventoPrestadorRepository
{
    private EventoPrestador $EventoPrestador;
    private Prestador $Prestador;
    private Evento $Evento;
    public function __construct()
    {
        $this->EventoPrestador = new EventoPrestador();
        $this->Prestador = new Prestador();
        $this->Evento = new Evento();
    }
    public function ifEventoid(int $userId, $data)
    {
        return $this->Evento->where('id',$data['evento_id'])->where('users_id',$userId)->first();
    } 
    public function ifPrestadorId($data)
    {
        return $this->Prestador->where('id',$data['prestador_id'])->first();
    } 
    
    /**
     * @throws DatabaseInsertException
     */
    public function store(int $iduser,$data)
    {
        if ($this->ifEventoid($iduser,$data) == null) {
            return 'Usuário sem Permissão';
        }
        if ($this->ifPrestadorId($data) == null) {
            return 'Prestador não encontrado';
        }
        $evento = $this->EventoPrestador->firstOrCreate([
            'evento_id' => $data['evento_id'],
            'prestador_id' => $data['prestador_id'],
            'aceitarPrestador' => $data['aceitarPrestador'],
        ]);
        return $evento;
        
    }
}
