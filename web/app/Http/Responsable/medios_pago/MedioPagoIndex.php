<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class MedioPagoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'medio_pago_index');
            $mediosPagoIndex = json_decode($peticion->getBody()->getContents());

            return view('medios_pago.index', compact('mediosPagoIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Consultando los medios de pago, contacte a Soporte.');
            return back();
        }
    }
}
