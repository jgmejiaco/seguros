<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class RolIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'rol_index');
            $rolesIndex = json_decode($response->getBody()->getContents());

            return view('roles.index', compact('rolesIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception rolesIndex, contacte a Soporte.');
            return back();
        }
    }
}
