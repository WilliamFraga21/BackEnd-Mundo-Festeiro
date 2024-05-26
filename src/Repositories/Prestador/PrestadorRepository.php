<?php

namespace MiniRest\Repositories\Prestador;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Profession\Profession;
use MiniRest\Models\Localidade\Localidade;
use MiniRest\Models\Prestador\PrestadorProfissao;
use Illuminate\Database\Capsule\Manager as DB;

class PrestadorRepository
{
    private Prestador $prestador;
    private Profession $profession;
    private PrestadorProfissao $prestadorprofession;
    private Localidade $localidade;

    public function __construct()
    {
        $this->prestador = new Prestador();
        $this->prestadorprofession = new PrestadorProfissao();
        $this->localidade = new Localidade();
    }

    public function getAll($id)
    {
        $prestadores = Prestador::select('*')->where('profissao_id',$id)->join('prestador_has_profissao','prestador.id','=','prestador_has_profissao.prestador_id')->get();
        // dd($prestadores);
        $data = [];

        foreach ($prestadores as $prestador) {
            $prestadorinfo = Prestador::select('prestador.id','prestador.users_id','prestador.promotorEvento', 'users.name', 'users.email', 'users.contactno', 'users.shippingAddress', 'users.shippingState', 'users.shippingCity','users.created_at','prestador.curriculo','prestador.localidade_id')
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

        $prestadorinfo = Prestador::select('prestador.id','prestador.promotorEvento', 'users.name', 'users.email', 'users.contactno', 'users.shippingAddress', 'users.shippingState', 'users.shippingCity','users.created_at','prestador.curriculo','prestador.localidade_id')
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

    public function me(int $userId)
    {

        $prestadorinfo = Prestador::select('prestador.id','prestador.promotorEvento', 'users.name', 'users.email', 'users.contactno', 'users.shippingAddress', 'users.shippingState', 'users.shippingCity','users.created_at','prestador.curriculo','prestador.localidade_id')
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
    public function storePrestador(int $userId, array $data, int $localidade)
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
                    'localidade_id' => $localidade,
                    'users_id' => $userId,
                    'promotorEvento' => $data['promotorEvento'],
                    'curriculo' => $data['curriculo'],
                ]
            );

        return $id->id;
    }

    public function updatePrestador(int $userId, array $data, $localidade)
    {
        return $this->prestador
            ->where('users_id', $userId)
            ->update(
                ['localidade_id' => $localidade],
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
