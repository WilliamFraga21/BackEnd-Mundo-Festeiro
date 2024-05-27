<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\Evento;
use MiniRest\Models\Evento\EventoProfession;
use MiniRest\Models\User;
use MiniRest\Models\Localidade\Localidade;
use MiniRest\Models\Profession\Profession;
use Illuminate\Database\Capsule\Manager as DB;
use SoftDeletes;

class EventoRepository
{
    private Evento $evento;
    private User $user;
    private Localidade $localidade;
    private Profession $profession;
    private EventoProfession $eventoprofession;

    public function __construct()
    {
        $this->evento = new Evento();
        $this->user = new User();
        $this->localidade = new Localidade();
        $this->profession = new Profession();
        $this->eventoprofession = new EventoProfession();
    }

    public function me(int $userId)
    {
        $idEvent = null;
        $Evento = $this->evento->select('*')->where('users_id', $userId)->get();
        $iduser = $this->user->where('id',$userId)->first();
        foreach ($Evento as $evento) {
            $idlocalidade = $this->localidade->where('id',$evento->localidade_id)->first();
            $idprofession = DB::table('evento_has_profissao')
                                ->select('profissao', 'profissao_id','quantidade')
                                ->join('profissao', 'evento_has_profissao.profissao_id', '=', 'profissao.id')
                                ->where('evento_has_profissao.evento_id', $evento->id)
                                ->get();
            $object = [
                'user' => $iduser,
                'evento' => $evento,
                'localidadeEvento' => $idlocalidade,
                'profissao' => $idprofession
            ];
            $idEvent[] = $object;
        }

        if ($idEvent == null) {
            
            return null;
        }else {

            return $idEvent;
        }
        
    }
    public function all($id)
    {
        $idEvent = null;
        $Evento = Evento::select('*')->where('profissao_id',$id)->join('evento_has_profissao','evento.id','=','evento_has_profissao.evento_id')->get();
        foreach ($Evento as $evento) {
            $iduser = $this->user->where('id',$evento->users_id)->first();
            $idlocalidade = $this->localidade->where('id',$evento->localidade_id)->first();
            $idprofession = DB::table('evento_has_profissao')
                                ->select('profissao', 'profissao_id','quantidade')
                                ->join('profissao', 'evento_has_profissao.profissao_id', '=', 'profissao.id')
                                ->where('evento_has_profissao.evento_id', $evento->id)
                                ->get();
            $object = [
                'user' => $iduser,
                'evento' => $evento,
                'localidadeEvento' => $idlocalidade,
                'profissao' => $idprofession
            ];
            $idEvent[] = $object;
        }
        
        if ($idEvent == null) {
            
            return null;
        }else {

            return $idEvent;
        }
    }

    public function find(int $eventoid)
    {
        $idEvent = null;
        $Evento = $this->evento->select('*')->where('id', $eventoid)->get();
        foreach ($Evento as $evento) {
            $iduser = $this->user->where('id',$evento->users_id)->first();
            $idlocalidade = $this->localidade->where('id',$evento->localidade_id)->first();
            $idprofession = DB::table('evento_has_profissao')
                                ->select('profissao', 'profissao_id','quantidade')
                                ->join('profissao', 'evento_has_profissao.profissao_id', '=', 'profissao.id')
                                ->where('evento_has_profissao.evento_id', $evento->id)
                                ->get();
            $object = [
                'user' => $iduser,
                'evento' => $evento,
                'localidadeEvento' => $idlocalidade,
                'profissao' => $idprofession
            ];
            $idEvent[] = $object;
        }
        
        if ($idEvent == null) {
            
            return null;
        }else {

            return $idEvent;
        }
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
    public function ifuserevento(int $userId, $id)
    {
        
    
        return $this->evento->select('deleted_at')->where('users_id',$userId)->where('id',$id)->first();
    } 
    
    

    /**
     * @throws DatabaseInsertException
     */
    public function store(int $idUser, array $data , int $localidade)
    {

        
        
        $evento = $this->evento->create([
            'data' => $data['data'],
            'nomeEvento' => $data['nomeEvento'],
            'tipoEvento' => $data['tipoEvento'],
            'quantidadePessoas' => $data['quantidadePessoas'],
            'quantidadeFuncionarios' => $data['quantidadeFuncionarios'],
            'statusEvento' => $data['statusEvento'],
            'descricaoEvento' => $data['descricaoEvento'],
            'users_id' => $idUser,
            'localidade_id' => $localidade,
        ]);
        // dd($evento);
        
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
