<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class QueryProducto implements Responsable
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
        $idProducto = $request->input('id_producto');

        try {
            $peticionQueryProducto = $this->clientApi->post($this->baseUri.'query_producto/'. $idProducto, [
                'json' => []
            ]);

            $resQueryProducto = json_decode($peticionQueryProducto->getBody()->getContents());
            
            if(isset($resQueryProducto) && $resQueryProducto) {
                return response()->json($resQueryProducto);
            }

        } catch (Exception $e) {
            return response()->json('error_exception');
        }
    }
}
