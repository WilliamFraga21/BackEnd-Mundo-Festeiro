<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Prestador\PrestadorProfissao;
use MiniRest\Models\Evento\EventoPrestador;
use MiniRest\Models\Photos;
use MiniRest\Models\Evento\Evento;
use SoftDeletes;

class EventoPrestadorRepository
{
    private EventoPrestador $EventoPrestador;
    private PrestadorProfissao $prestadorProfessions;
    private Prestador $Prestador;
    private Evento $Evento;
    private Photos $photo;
    public function __construct()
    {
        $this->prestadorProfessions = new PrestadorProfissao();
        $this->EventoPrestador = new EventoPrestador();
        $this->Prestador = new Prestador();
        $this->Evento = new Evento();
        $this->photo = new Photos();
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
        ]);
        return $evento;
        
    } 
    public function aceitar(int $id,)
    {
        $ifproposta = $this->EventoPrestador->where('id',$id)->first();

        if ($ifproposta == null) {
            return null;
        } else {
            $proposta = $this->EventoPrestador->where('id',$id)->update(['aceitarPrestador' =>1]);
            return $proposta;
        }
        

        
    } 
    public function getprestadores(int $id)
    {
        
        $evento = $this->Evento->where('id', $id)->first();
        if ($evento == null) {
            return "Evento não encontrado";
        }else{
            // $prestadores = EventoPrestador::select('');
            
                $prestadorInfo = EventoPrestador::select('prestador_has_evento.id as id_proposta', 'prestador_has_evento.aceitarPrestador', 'prestador_has_evento.prestador_id', 'prestador_has_evento.evento_id', 'users.name as user_name', 'users.email', 'users.contactno', 'users.created_at')
                    ->join('prestador', 'prestador_has_evento.prestador_id', '=', 'prestador.id')
                    ->join('users', 'prestador.users_id', '=', 'users.id')
                    ->where('prestador_has_evento.evento_id', $id)
                    ->first();

            // Verifica se encontrou um prestador
            if ($prestadorInfo) {
                // Obtém as profissões do prestador
                $professions = 
                PrestadorProfissao::join('profissao', 'prestador_has_profissao.profissao_id', '=', 'profissao.id')
                    ->where('prestador_has_profissao.prestador_id', $prestadorInfo->prestador_id)
                    ->select('profissao.profissao', 'prestador_has_profissao.tempoexperiencia', 'prestador_has_profissao.valorDiaServicoProfissao', 'prestador_has_profissao.valorHoraServicoProfissao')
                    ->get();

                // Obtém a foto do usuário
                $avatar = Photos::where('avatar.users_id', $prestadorInfo->prestador_id)
                    ->select('avatar.avatar')
                    ->first();

                // Cria um objeto com todas as informações necessárias
                $prestadorData = (object)[
                    'prestadorInfo' => $prestadorInfo,
                    'professions' => $professions,
                    'avatar' => $avatar ? $avatar->avatar : null,
                ];

                // Exibe as informações
                return $prestadorData;
            } else {
                return 'Nenhum prestador encontrado para o evento.';
            }


            
        }



    }
}
