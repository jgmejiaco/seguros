<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PermisoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'permiso_index');
            $permisosIndex = json_decode($peticion->getBody()->getContents());

            return view('permisos.index', compact('permisosIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Error consultando los permisos, contacte a Soporte.');
            return back();
        }
    }
}
