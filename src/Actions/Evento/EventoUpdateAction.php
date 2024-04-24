<?php

namespace MiniRest\Actions\Evento;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Evento\EventoCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\Evento;
use MiniRest\Repositories\Localidade\LocalidadeRepository;
use MiniRest\Repositories\Evento\EventoRepository;

class EventoUpdateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, EventoCreateDTO $prestadorCreateDTO)
    {
        $prestadorData = $prestadorCreateDTO->toArray();

        DB::beginTransaction();
        try {

            $prestador = Evento::where('users_id', $userId)->firstOrFail();
            $prestadorId = $prestador->users_id;



            $idLocalidade = (new LocalidadeRepository())->storeLocalidade($prestadorData);
            // (new EventoRepository())->updatePrestador($userId, $prestadorData,$idLocalidade);



            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw new DatabaseInsertException(
                "error ao inserir o prestador " . $exception->getMessage(),
                StatusCode::SERVER_ERROR
            );
        }
    }
}