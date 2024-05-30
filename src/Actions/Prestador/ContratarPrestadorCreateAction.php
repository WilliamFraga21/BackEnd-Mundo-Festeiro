<?php

namespace MiniRest\Actions\Prestador;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Repositories\Prestador\PrestadorRepository;

class ContratarPrestadorCreateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, int $idPrestador)
    {
        // $prestadorData = $prestadorCreateDTO->toArray();
        // dd($userId);

        DB::beginTransaction();
        try {
            $prestadorId = (new PrestadorRepository())->contrataPrestador($idPrestador, $userId);

            // dd((new PrestadorRepository())->contrataPrestador($idPrestador, $userId));

            DB::commit();
            return $prestadorId;
        } catch (\Exception $exception) {
            DB::rollback();

            // Certifique-se de que o código da exceção seja um número inteiro
            $code = is_int($exception->getCode()) ? $exception->getCode() : 0;

            throw new DatabaseInsertException(
                $exception->getMessage(),
                $code
            );
        }
    }
}
