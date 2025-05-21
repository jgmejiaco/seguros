<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class ConsultorIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'consultor_index');
            $consultoresIndex = json_decode($response->getBody()->getContents());

            return view('consultores.index', compact('consultoresIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception consultoresIndex, contacte a Soporte.');
            return back();
        }
    }
}
