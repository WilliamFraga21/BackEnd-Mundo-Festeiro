<?php

namespace MiniRest\Actions\Prestador;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Prestador\PrestadorProfessionCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Repositories\Prestador\PrestadorProfesionRepository;

class PrestadorProfessionCreateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(PrestadorProfessionCreateDTO $prestadorCreateDTO, $userId)
    {
        $prestadorData = $prestadorCreateDTO->toArray();
        dd($prestadorCreateDTO);
        DB::beginTransaction();
        try {

            foreach($prestadorData['profession'] as $prefession){
                $idProfessionPrestador = (new PrestadorProfesionRepository())->store($prefession, $userId);
            }

        

            DB::commit();
            return $idProfessionPrestador;

        } catch (\Exception $exception) {
            DB::rollback();

            throw new DatabaseInsertException(
                $exception->getMessage(),
                StatusCode::NOT_FOUND
            );

        }
    }
}