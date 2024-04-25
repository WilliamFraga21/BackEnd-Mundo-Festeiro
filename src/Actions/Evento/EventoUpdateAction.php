<?php

namespace MiniRest\Actions\Evento;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Evento\EventoCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Exceptions\Exception;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Evento\Evento;
use MiniRest\Repositories\Localidade\LocalidadeRepository;
use MiniRest\Repositories\Evento\EventoRepository;
use MiniRest\Repositories\Evento\EventoProfessionRepository;
use MiniRest\Http\Response\Response;

class EventoUpdateAction
{

    private EventoRepository $Evento;

    public function __construct()
    {
        $this->Evento = new EventoRepository();
    }

    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, EventoCreateDTO $eventoCreateDTO,int $id)
    {
        $eventoData = $eventoCreateDTO->toArray();

        DB::beginTransaction();
        try {
            
            $idLocalidade = (new LocalidadeRepository())->storeLocalidade($eventoData);
            $eventoId = (new EventoRepository())->update($userId, $eventoData,$idLocalidade,$id);

            foreach  ($eventoData['professions'] as $profession){
                
                $professionId = (new EventoProfessionRepository())->store($profession,$id);
            }



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