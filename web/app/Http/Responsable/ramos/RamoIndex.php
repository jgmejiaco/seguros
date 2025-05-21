<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class RamoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'ramo_index');
            $ramosIndex = json_decode($response->getBody()->getContents());

            return view('ramos.index', compact('ramosIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception ramosIndex, contacte a Soporte.');
            return back();
        }
    }
}
