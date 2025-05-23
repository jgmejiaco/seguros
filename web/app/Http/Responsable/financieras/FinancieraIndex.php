<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class FinancieraIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'financiera_index');
            $financierasIndex = json_decode($peticion->getBody()->getContents());

            return view('financieras.index', compact('financierasIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Consultando las financieras, contacte a Soporte.');
            return back();
        }
    }
}
