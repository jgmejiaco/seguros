<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use App\Models\Usuario;

class UsuarioUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario'        => 'required|string',
            'nombre_usuario'    => 'required|string',
            'apellido_usuario'  => 'required|string',
            'correo'            => 'required|email',
            'id_rol'            => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errores' => $validator->errors()
            ], 422);
        }

        // Si pasa la validación
        $idUsuario = $request->input('id_usuario');
        $nombreUsuario = $request->input('nombre_usuario');
        $apellidoUsuario = $request->input('apellido_usuario');
        $correo = $request->input('correo');
        $idRol = $request->input('id_rol');

        try {
            $peticionUsuarioUpdate = $this->clientApi->put($this->baseUri .'usuario_update/'. $idUsuario, [
                'json' => [
                    'nombre_usuario' => $nombreUsuario,
                    'apellido_usuario' => $apellidoUsuario,
                    'correo' => $correo,
                    'id_rol' => $idRol,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resUsuarioUpdate = json_decode($peticionUsuarioUpdate->getBody()->getContents());

            if(isset($resUsuarioUpdate->success) && $resUsuarioUpdate->success === true) {
                return $this->respuestaExito(
                    'Usuario editado satisfactoriamente.', 'usuarios.index'
                );
            }
        } catch (Exception $e) {
            return $this->respuestaException('Exception, contacte a Soporte.');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método auxiliar para mensajes de exito
    private function respuestaExito($mensaje, $ruta)
    {
        alert()->success('Exito', $mensaje);
        return redirect()->to(route($ruta));
    }

    // ========================================================

    // Método auxiliar para manejar errores
    private function respuestaError($mensaje, $ruta)
    {
        alert()->error('Error', $mensaje);
        return redirect()->to(route($ruta));
    }

    // ========================================================

    // Método auxiliar para manejar excepciones
    private function respuestaException($mensaje)
    {
        alert()->error('Error', $mensaje);
        return back();
    }
}
