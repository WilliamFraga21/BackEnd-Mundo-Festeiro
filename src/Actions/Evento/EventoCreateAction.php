<?php

namespace MiniRest\Actions\Evento;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Evento\EventoCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Repositories\Evento\EventoRepository;
use MiniRest\Repositories\Evento\EventoProfessionRepository;
use MiniRest\Repositories\Localidade\LocalidadeRepository;

class EventoCreateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, EventoCreateDTO $eventoCreateDTO)
    {
        $eventoData = $eventoCreateDTO->toArray();

        try {
            $idLocalidade = (new LocalidadeRepository())->storeLocalidade($eventoData);
            $eventoId = (new EventoRepository())->store($userId, $eventoData,$idLocalidade);
            dd($userId);

            
            foreach  ($eventoData['professions'] as $profession){
                
                $professionId = (new EventoProfessionRepository())->store($profession,$eventoId);
            }
            
        

            return $eventoId;

        } catch (DatabaseInsertException $exception) {
            throw new DatabaseInsertException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}