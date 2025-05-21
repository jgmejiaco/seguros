<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class GerenteIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'gerente_index');
            $gerentesIndex = json_decode($response->getBody()->getContents());

            return view('gerentes.index', compact('gerentesIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception gerentesIndex, contacte a Soporte.');
            return back();
        }
    }
}
