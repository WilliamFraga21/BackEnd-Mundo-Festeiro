<?php

namespace MiniRest\Repositories\Evento;

use Exception;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Prestador\PrestadorProfissao;
use MiniRest\Models\Evento\EventoPrestador;
use MiniRest\Models\Localidade\Localidade;
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
    private Localidade $localidade;
    public function __construct()
    {
        $this->prestadorProfessions = new PrestadorProfissao();
        $this->EventoPrestador = new EventoPrestador();
        $this->Prestador = new Prestador();
        $this->Evento = new Evento();
        $this->photo = new Photos();
        $this->localidade = new Localidade();
    }
    public function ifEventoid(int $userId, $data)
    {
        return $this->Evento->where('id',$data['evento_id'])->where('users_id',$userId)->first();
    } 
    public function ifPrestadorId($data)
    {
        return $this->Prestador->where('id',$data)->first();
    }  
    public function getPrestador($data)
    {
        return $this->Prestador->where('users_id',$data)->first();
    } 
    
    /**
     * @throws DatabaseInsertException
     */
    public function store($prestador,$data)
    {
        // if ($this->ifEventoid($iduser,$data) == null) {
        //     return 'Usuário sem Permissão';
        // }
        // dd($data);
        if ($this->ifPrestadorId($prestador) == null) {
            return 'Prestador não encontrado';
        }
        $evento = $this->EventoPrestador->firstOrCreate([
            'evento_id' => $data['evento_id'],
            'profissao' => $data['profissao'],
            'prestador_id' => $prestador,
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
            
            $prestadoresInfo = EventoPrestador::select(
                'prestador_has_evento.id as id_proposta',
                'prestador_has_evento.aceitarPrestador',
                'prestador_has_evento.prestador_id',
                'prestador_has_evento.evento_id',
                'prestador_has_evento.profissao',
                'users.name as user_name',
                'users.id as idUser',
                'users.email',
                'users.idade',
                'users.contactno',
                'users.created_at',
                'users.localidade_id as localidadeUser',
                'prestador.curriculo',
            )
                ->join('prestador', 'prestador_has_evento.prestador_id', '=', 'prestador.id')
                ->join('users', 'prestador.users_id', '=', 'users.id')
                ->where('prestador_has_evento.evento_id', $evento->id)
                ->get();
        
            // Verifica se encontrou prestadores
            if ($prestadoresInfo->isEmpty()) {
                return 'Nenhum prestador encontrado para o evento.';
            }
        
            // Cria um array para armazenar as informações completas dos prestadores
            $prestadoresData = [];
        
            // Percorre cada prestador para obter suas profissões e a foto
            foreach ($prestadoresInfo as $prestadorInfo) {
                // Obtém as profissões do prestador
                $professions = PrestadorProfissao::join('profissao', 'prestador_has_profissao.profissao_id', '=', 'profissao.id')
                    ->where('prestador_has_profissao.prestador_id', $prestadorInfo->prestador_id)
                    ->select('profissao.profissao', 'prestador_has_profissao.tempoexperiencia', 'prestador_has_profissao.valorDiaServicoProfissao', 'prestador_has_profissao.valorHoraServicoProfissao')
                    ->get();
        

                    $localidade = Localidade::where('id',$prestadorInfo->localidadeUser)->first();
                // Obtém a foto do usuário
                $avatar = Photos::where('avatar.users_id', $prestadorInfo->idUser)
                    ->select('avatar.avatar')
                    ->first();


        
                // Adiciona todas as informações do prestador a um array
                $prestadoresData[] = (object)[
                    'prestadorInfo' => $prestadorInfo,
                    'professions' => $professions,
                    'localidade' => $localidade,
                    'photo' => $avatar ? $avatar->avatar : null,
                ];
            }
        
            // Retorna as informações completas dos prestadores
            return $prestadoresData;

            
        }



    }
}
