<?php

namespace App\Http\Responsable\audits;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class AuditIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'audit_index');
            $auditsIndex = json_decode($peticion->getBody()->getContents());

            return view('audits.index', compact('auditsIndex'));

        } catch (Exception $e) {
            alert()->error('Error consultando las Auditorias, contacte a Soporte.');
            return back();
        }
    }
}
