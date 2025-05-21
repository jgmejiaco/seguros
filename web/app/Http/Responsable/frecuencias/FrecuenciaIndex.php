<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class FrecuenciaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'frecuencia_index');
            $frecuenciasIndex = json_decode($response->getBody()->getContents());

            return view('frecuencias.index', compact('frecuenciasIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception frecuenciasIndex, contacte a Soporte.');
            return back();
        }
    }
}
