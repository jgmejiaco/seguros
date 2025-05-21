<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use App\Models\Usuario;

class UsuarioDestroy implements Responsable
{
    use MetodosTrait;
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
            $peticionCambiarEstadoUsuario = $this->clientApi->post($this->baseUri.'cambiar_estado_usuario/'. $this->idUsuario,
                [
                    'json' => ['id_audit' => session('id_usuario')]
                ]
            );
            $resCambioEstadoUsuario = json_decode($peticionCambiarEstadoUsuario->getBody()->getContents());

            if(isset($resCambioEstadoUsuario->success) && $resCambioEstadoUsuario->success === true) {

                $usuarioLogueado = session('id_usuario');

                if ($usuarioLogueado != $this->idUsuario) {
                    alert()->success('Proceso Exitoso', 'Estado cambiado satisfactoriamente');
                    return redirect()->to(route('usuarios.index'));
                } else {
                    alert()->success('Proceso Exitoso', 'Estado cambiado satisfactoriamente');
                    return redirect()->to(route('logout'));
                }
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Cambiando el estado del Usuario, contacte a Soporte.');
            return back();
        }
    }
}
