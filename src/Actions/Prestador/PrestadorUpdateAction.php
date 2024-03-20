<?php

namespace MiniRest\Actions\Prestador;

use Illuminate\Database\Capsule\Manager as DB;
use MiniRest\DTO\Prestador\PrestadorCreateDTO;
use MiniRest\Exceptions\DatabaseInsertException;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Models\Prestador\Prestador;
use MiniRest\Repositories\Localidade\LocalidadeRepository;
use MiniRest\Repositories\Prestador\ApresentacaoRepository;
use MiniRest\Repositories\Prestador\PrestadorProfessionRepository;
use MiniRest\Repositories\Prestador\PrestadorRepository;
use MiniRest\Repositories\Prestador\PrestadorSkillsRepository;

class PrestadorUpdateAction
{
    /**
     * @throws DatabaseInsertException
     */
    public function execute(int $userId, PrestadorCreateDTO $prestadorCreateDTO)
    {
        $prestadorData = $prestadorCreateDTO->toArray();

        DB::beginTransaction();
        try {

            $prestador = Prestador::where('users_id', $userId)->firstOrFail();
            $prestadorId = $prestador->users_id;



            $idLocalidade = (new LocalidadeRepository())->storeLocalidade($prestadorData);
            (new PrestadorRepository())->updatePrestador($userId, $prestadorData,$idLocalidade);



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