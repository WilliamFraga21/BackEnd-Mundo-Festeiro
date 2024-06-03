<?php

namespace MiniRest\Actions\Evento;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Evento\EventoPrestadorDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Repositories\Evento\EventoPrestadorRepository;

class EventoPrestadorCreateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute($prestador,EventoPrestadorDTO $eventoPrestadorCreateDTO)
    {
        $eventoPrestadorData = $eventoPrestadorCreateDTO->toArray();
        try {
            $eventoPrestadorId = (new EventoPrestadorRepository())->store($prestador ,$eventoPrestadorData);
            return $eventoPrestadorId;
        } catch (DatabaseInsertException $exception) {

            throw new $exception;
        }
    }
}