<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class AseguradoraIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'aseguradora_index');
            $aseguradorasIndex = json_decode($response->getBody()->getContents());

            return view('aseguradoras.index', compact('aseguradorasIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception aseguradorasIndex, contacte a Soporte.');
            return back();
        }
    }
}
