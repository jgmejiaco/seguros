<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class LineaPersonalIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'linea_personal_index');
            $lineasPersonalesIndex = json_decode($response->getBody()->getContents());

            return view('lineas_personales.index', compact('lineasPersonalesIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception lineasPersonalesIndex, contacte a Soporte.');
            return back();
        }
    }
}
