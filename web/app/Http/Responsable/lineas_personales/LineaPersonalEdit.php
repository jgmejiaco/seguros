<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use App\Models\Usuario;

class LineaPersonalEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idLineasPersonal;

    public function __construct($idLineasPersonal)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idLineasPersonal = $idLineasPersonal;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionLineaPersonalEdit = $this->clientApi->get($this->baseUri.'linea_personal_edit/'. $this->idLineasPersonal, [
                'json' => []
            ]);
            return json_decode($peticionLineaPersonalEdit->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando el radicado, contacte a soporte');
            return back();
        }
    }
}
