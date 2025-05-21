<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class QueryConsultor implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $idConsultor = $request->input('id_consultor');

        try {
            $peticionQueryConsultor = $this->clientApi->post($this->baseUri.'query_consultor/'. $idConsultor, [
                'json' => []
            ]);

            $resQueryConsultor = json_decode($peticionQueryConsultor->getBody()->getContents());
            
            if(isset($resQueryConsultor) && $resQueryConsultor) {
                return response()->json($resQueryConsultor);
            }

        } catch (Exception $e) {
            return response()->json('error_exception');
        }
    }
}
