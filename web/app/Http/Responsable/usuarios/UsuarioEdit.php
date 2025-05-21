<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class UsuarioEdit implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idUsuario = $idUsuario;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            // Realiza la solicitud a la API
            $peticion = $this->clientApi->get($this->baseUri . 'usuario_edit/'. $this->idUsuario);
            $usuario = json_decode($peticion->getBody()->getContents());

            // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'editar_usuario'); // valor por defecto

            return match ($tipoModal) {
                'cambiar_clave'  => view('usuarios.modal_cambiar_clave', compact('usuario')),
                'cambiar_estado' => view('usuarios.modal_cambiar_estado', compact('usuario')),
                default          => view('usuarios.modal_editar_usuario', compact('usuario')),
            };

        } catch (Exception $e) {
            dd($e);
            alert()->error('Error', 'Editando el Usuario, contacte a Soporte.');
            return back();
        }
    }
}
