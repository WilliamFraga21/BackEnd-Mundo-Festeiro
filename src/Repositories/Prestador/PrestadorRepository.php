<?php

namespace MiniRest\Repositories\Prestador;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Prestador\PrestadorAceitar;
use MiniRest\Models\Profession\Profession;
use MiniRest\Models\Evento\EventoPrestador;
use MiniRest\Models\User;
use MiniRest\Models\Evento\Evento;
use MiniRest\Models\Localidade\Localidade;
use MiniRest\Models\Prestador\PrestadorProfissao;
use Illuminate\Database\Capsule\Manager as DB;

class PrestadorRepository
{
    private Prestador $prestador;
    private Profession $profession;
    private PrestadorProfissao $prestadorprofession;
    private Localidade $localidade;
    private PrestadorAceitar $prestadorAceitar;
    private EventoPrestador $prestadorEvento;
    private Evento $evento;
    private User $user;

    public function __construct()
    {
        $this->user = new User();
        $this->prestador = new Prestador();
        $this->prestadorprofession = new PrestadorProfissao();
        $this->localidade = new Localidade();
        $this->prestadorAceitar = new PrestadorAceitar();
        $this->prestadorEvento = new EventoPrestador();
        $this->evento = new Evento();
    }

    public function getAll($id)
    {
        $prestadores = Prestador::select('*')->where('profissao_id',$id)->join('prestador_has_profissao','prestador.id','=','prestador_has_profissao.prestador_id')->get();
        // dd($prestadores);
        $data = [];

        foreach ($prestadores as $prestador) {
            $prestadorinfo = Prestador::select('prestador.id','prestador.users_id','prestador.promotorEvento', 'users.name', 'users.localidade_id','users.email', 'users.contactno','users.created_at','prestador.curriculo')
            ->where('users_id', $prestador->users_id)
            ->join('users', 'prestador.users_id','=','users.id')
                ->first();
            
                $infoPrestadorEnd = $this->localidade->where('id',$prestadorinfo->localidade_id)->first();
                
                if ($this->prestadorprofession->where('prestador_id',$prestadorinfo->id)->first()) {
                    # code...
                    $prestadorProfessions = $this->prestadorprofession->where('prestador_id', $prestadorinfo->id)->get();

                    $profissaoArray = [];

                    foreach ($prestadorProfessions as $prestadorProfession) {
                        $profissaoInfo = Profession::join('prestador_has_profissao', 'profissao.id', '=', 'prestador_has_profissao.profissao_id')
                            ->where('prestador_has_profissao.profissao_id', $prestadorProfession->profissao_id)
                            ->first(['profissao.id','profissao.profissao', 'prestador_has_profissao.tempoexperiencia', 'prestador_has_profissao.valorDiaServicoProfissao', 'prestador_has_profissao.valorHoraServicoProfissao']);

                        if ($profissaoInfo) {
                            $profissaoArray[] = $profissaoInfo->toArray();
                        }
                    }

                    // dd($profissaoArray);





                }else {
                    $profissaoArray = null;
                }

            

            $data[] = [
                'prestadorInfo' => $prestadorinfo,
                'prestadorprofessions' => $profissaoArray,
                'infoPrestadorEnd' => $infoPrestadorEnd,
            ];
        }



        return $data;
    }

    /**
     * @throws PrestadorNotFoundException
     */
    public function find(int|string $prestadorId)
    {

        $prestadorinfo = Prestador::select('prestador.id','prestador.users_id','prestador.promotorEvento', 'users.name', 'users.email', 'users.contactno','users.localidade_id','users.created_at','prestador.curriculo')
                                    ->where('prestador.id', $prestadorId)
                                    ->join('users', 'prestador.users_id','=','users.id')
                                    ->first();
            $infoPrestadorEnd = $this->localidade->where('id',$prestadorinfo->localidade_id)->first();
            if ($this->prestadorprofession->where('prestador_id',$prestadorinfo->id)->first()) {
                $prestadorProfessions = $this->prestadorprofession->where('prestador_id', $prestadorinfo->id)->get();
                $profissaoArray = [];
                foreach ($prestadorProfessions as $prestadorProfession) {
                    $profissaoInfo = Profession::join('prestador_has_profissao', 'profissao.id', '=', 'prestador_has_profissao.profissao_id')
                        ->where('prestador_has_profissao.profissao_id', $prestadorProfession->profissao_id)
                        ->first(['profissao.id','profissao.profissao', 'prestador_has_profissao.tempoexperiencia', 'prestador_has_profissao.valorDiaServicoProfissao', 'prestador_has_profissao.valorHoraServicoProfissao']);

                    if ($profissaoInfo) {
                        $profissaoArray[] = $profissaoInfo->toArray();
                    }
                }
            }else {
                $profissaoArray = null;
            }
        $data[] = [
            'prestadorInfo' => $prestadorinfo,
            'prestadorprofessions' => $profissaoArray,
            'infoPrestadorEnd' => $infoPrestadorEnd,
        ];
        return $data;


    }
    public function find2(int|string $prestadorId)
    {

        $prestadorinfo = Prestador::select('prestador.users_id')
                                    ->where('prestador.id', $prestadorId)
                                    ->join('users', 'prestador.users_id','=','users.id')
                                    ->first();
        
        return $prestadorinfo->users_id;


    } 
    public function getPrestador($data)
    {
        return $this->prestador->where('users_id',$data)->first();
    } 
    public function getpropostas(int|string $userid)
    {
        $prestadorid = $this->prestador->where('users_id', $userid)->first();
        if ($prestadorid == null ) {
            return "Prestador não encontrado";
        }else{
            
            $propostas = User::select("users.name","users.email","users.contactno","users.id as userID","contrar_prestador.id as propostaID","contrar_prestador.profession as profissao",'aceitarProposta',"contrar_prestador.prestador_id","contrar_prestador.created_at as dataProposta")
            ->where('contrar_prestador.prestador_id',$prestadorid->id)
            ->join('contrar_prestador','users.id', '=' ,'contrar_prestador.users_id')
            ->get();
            // dd($propostas);
            // $prestadorinfo = $this->prestadorAceitar->where('prestador_id',$prestadorid->id)->get();
            // $prestadorinfo =Prestador::select("*")->get();
            return $propostas;
        }




    }  
    public function getEventos(int|string $userid)
    {

        $prestadorid = $this->prestador->where('users_id', $userid)->first();
        if ($prestadorid == null ) {
           return "Prestador não encontrado";
        }else{

            $prestadorInfo = Evento::select(
                'prestador_has_evento.evento_id',
                'evento.id as evento_id',
                'evento.nomeEvento',
                'evento.tipoEvento',
                'evento.descricaoEvento',
                'imgevento.img as evento_imagem',
            
            )
            ->join('prestador_has_evento', 'evento.id', '=', 'prestador_has_evento.evento_id')
            ->leftjoin('imgevento', 'evento.id', '=', 'imgevento.evento_id')
            ->where('prestador_has_evento.prestador_id', $prestadorid->id)
            ->get();
        
    
    

                // Exibe as informações
                return $prestadorInfo;
        

        }




    } 
    public function contrataPrestador($data,$idUser)
    {
        // dd($prestador = $this->prestadorAceitar->firstOrCreate(
        //     [
        //         'prestador_id' => $data,
        //         'users_id' => $idUser,
        //     ],
        //     [
        //         'aceitarProposta' => 0,
        //     ]
        // )
        // );
        $prestador = $this->prestadorAceitar->firstOrCreate(
            [ 'prestador_id' => $data['idprestador'],
            'profession' => $data['profession'],
            'users_id' => $idUser,],
            [
                'aceitarProposta' => 0,
                'prestador_id' => $data['idprestador'],
                'profession' => $data['profession'],
                'users_id' => $idUser,
                ]
            );
            
            // dd($prestador);
        return $prestador;


    }
    public function PrestadorAceitar($id,$idprestador)
    {

        $prestador = $this->prestadorAceitar->where('id',$id)->where('prestador_id',$idprestador)->update(['aceitarProposta' => 1]);
        return $prestador;
    }

    public function me(int $userId)
    {

        $prestadorinfo = Prestador::select('prestador.id','prestador.users_id','prestador.promotorEvento', 'users.name', 'users.email','users.localidade_id', 'users.contactno','users.created_at','prestador.curriculo')
                                    ->where('users_id', $userId)
                                    ->join('users', 'prestador.users_id','=','users.id')
                                    ->first();
                                    $infoPrestadorEnd = $this->localidade->where('id',$prestadorinfo->localidade_id)->first();
            if ($this->prestadorprofession->where('prestador_id',$prestadorinfo->id)->first()) {
                $prestadorProfessions = $this->prestadorprofession->where('prestador_id', $prestadorinfo->id)->get();
                $profissaoArray = [];
                foreach ($prestadorProfessions as $prestadorProfession) {
                    $profissaoInfo = Profession::join('prestador_has_profissao', 'profissao.id', '=', 'prestador_has_profissao.profissao_id')
                        ->where('prestador_has_profissao.profissao_id', $prestadorProfession->profissao_id)
                        ->first(['profissao.id','profissao.profissao', 'prestador_has_profissao.tempoexperiencia', 'prestador_has_profissao.valorDiaServicoProfissao', 'prestador_has_profissao.valorHoraServicoProfissao']);

                    if ($profissaoInfo) {
                        $profissaoArray[] = $profissaoInfo->toArray();
                    }
                }
            }else {
                $profissaoArray = null;
            }
        $data[] = [
            'prestadorInfo' => $prestadorinfo,
            'prestadorprofessions' => $profissaoArray,
            'infoPrestadorEnd' => $infoPrestadorEnd,
        ];
        return $data;
    }
    public function meProfession(int $userId)
    {

        $prestador = $this->prestador->where('users_id', $userId)->first();


        return $prestador;
    }

    public function byid(int $userId)
    {

        // dd( $this->prestador->where('users_id', $userId)->first());
        return $this->prestador->where('users_id', $userId)->first();
    }

    /**
     * @throws DatabaseInsertException
     */
    public function storePrestador(int $userId, array $data)
    {

        // dd($localidade);
        if ($this->byid($userId)) {
            throw new DatabaseInsertException(
                'error ao fazer o insert, prestador já foi cadastrado.',
                StatusCode::NOT_FOUND
            );
        }
        
        $id = $this->prestador
            ->firstOrCreate(
                ['users_id' => $userId],
                [
                    'users_id' => $userId,
                    'promotorEvento' => $data['promotorEvento'],
                    'curriculo' => $data['curriculo'],
                ]
            );

        return $id->id;
    }

    public function updatePrestador(int $userId, array $data)
    {
        return $this->prestador
            ->where('users_id', $userId)
            ->update(
                [
                    'promotorEvento' => $data['promotorEvento'],
                    'curriculo' => $data['curriculo'],
                ]
            );
    }

    public function getPrestadorByUserId(int $userId)
    {
        $prestador = Prestador::where('users_id', $userId)->first();
        if ($prestador) {
            return $prestador->users_id;
        }
    }
}
