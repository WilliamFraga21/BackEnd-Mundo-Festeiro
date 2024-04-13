<?php

namespace MiniRest\Actions\Prestador;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Prestador\PrestadorProfessionCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Repositories\Prestador\PrestadorProfesionRepository;

class PrestadorProfessionUpdateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(PrestadorProfessionCreateDTO $prestadorCreateDTO, $userId)
    {
        $prestadorData = $prestadorCreateDTO->toArray();

        DB::beginTransaction();
        try {


            foreach($prestadorData['profession'] as $profession){
                
                $idProfessionPrestador = (new PrestadorProfesionRepository())->updateProfesionPrestador($profession, $userId);
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