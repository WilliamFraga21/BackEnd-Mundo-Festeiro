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


    
    public function dellid( $id)
    {
        
        $Evento =  $this->evento->where('id',$id)->delete();
        
        return $Evento;
    }

    
    public function ifdellid(int $userId, $id)
    {
        
        if (!$this->evento->select('deleted_at')->where('users_id',$userId)->where('id',$id)->first() ) {
            return 'ja deletado';
        }
    
        return $this->evento->where('users_id',$userId)->where('id',$id)->first();
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

    public function update( int $idUser, array $data , int $localidade,int $idEvento)
    {
        return $this->evento
            ->where('users_id', $idUser)->where('id',$idEvento)
            ->update(
                
                [
                    'nomeEvento' => $data['nomeEvento'],
                    'tipoEvento' => $data['tipoEvento'],
                    'data' => $data['data'],
                    'quantidadePessoas' => $data['quantidadePessoas'],
                    'quantidadeFuncionarios' => $data['quantidadeFuncionarios'],
                    'statusEvento' => $data['statusEvento'],
                    'descricaoEvento' => $data['descricaoEvento'],
                    'users_id' => $idUser,
                    'localidade_id' => $localidade,
                ]
            );
    }

    
}
