<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class EstadoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'estado_index');
            $estadosIndex = json_decode($response->getBody()->getContents());

            return view('estados.index', compact('estadosIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception estadosIndex, contacte a Soporte.');
            return back();
        }
    }
}
