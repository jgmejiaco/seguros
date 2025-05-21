<?php

namespace App\Http\Responsable\asignar_permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class AsignarPermisoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'asignar_permiso_index');
            $permisosAsignados = json_decode($peticion->getBody()->getContents());

            return view('asignar_permisos.index', compact('permisosAsignados'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception consultoresIndex, contacte a Soporte.');
            return back();
        }
    }
}
