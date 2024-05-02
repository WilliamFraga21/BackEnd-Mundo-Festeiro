<?php

namespace MiniRest\Repositories\Prestador;

use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\PrestadorNotFoundException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Models\Prestador\PrestadorProfissao;
use Illuminate\Database\Capsule\Manager as DB;

class PrestadorRepository
{
    private Prestador $prestador;
    private PrestadorProfissao $prestadorprofession;

    public function __construct()
    {
        $this->prestador = new Prestador();
        $this->prestadorprofession = new PrestadorProfissao();
    }

    public function getAll()
    {
        $prestadores = Prestador::all();
        $data = [];

        foreach ($prestadores as $prestador) {
            $prestadorAll = Prestador::select('prestador.id','users.id','prestador.promotorEvento', 'users.name', 'users.email', 'users.contactno', 'users.shippingAddress', 'users.shippingState', 'users.shippingCity','users.created_at')
                ->where('users_id', $prestador->users_id)
                ->join('users', 'prestador.users_id','=','users.id')
                ->first();

            

            $data[] = [
                'prestadorInfo' => $prestadorAll,

            ];
        }



        return $data;
    }

    /**
     * @throws PrestadorNotFoundException
     */
    public function find(int|string $prestadorId)
    {


        $dataPrestador = $this->prestador->where('id', $prestadorId)->first();

        $professionPrestador = $this->prestadorprofession->where('prestador_id',$dataPrestador->id)->get();

        dd( $professionPrestador);

        return $this->prestador->where('id', $prestadorId)->first();
    }

    public function me(int $userId)
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
