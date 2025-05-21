<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class UsuarioIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'usuarios_index');
            $usuariosIndex = json_decode($response->getBody()->getContents());

            return view('usuarios.index', compact('usuariosIndex'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception usuariosIndex, contacte a Soporte.');
            return back();
        }
    }
}
