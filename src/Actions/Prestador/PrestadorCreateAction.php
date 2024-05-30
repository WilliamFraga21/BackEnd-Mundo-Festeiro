<?php

namespace MiniRest\Actions\Prestador;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Prestador\PrestadorCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Repositories\Prestador\PrestadorRepository;
use MiniRest\Repositories\Localidade\LocalidadeRepository;

class PrestadorCreateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, PrestadorCreateDTO $prestadorCreateDTO)
    {
        $prestadorData = $prestadorCreateDTO->toArray();

        DB::beginTransaction();
        try {
            
            $prestadorId = (new PrestadorRepository())->storePrestador($userId, $prestadorData);
            // dd($prestadorId);


            DB::commit();
            return $prestadorId;

        } catch (\Exception $exception) {
            DB::rollback();
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}