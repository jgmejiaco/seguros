<?php

namespace App\Http\Responsable\inicio_sesion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\Usuario;

class LoginStore implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    public function toResponse($request)
    {
        $usuario = $request->input('usuario');
        $clave = $request->input('clave');

        if(!isset($usuario) || empty($usuario) || is_null($usuario) || !isset($clave) || empty($clave) || is_null($clave)) {
            alert()->error('Error','Usuario y Clave son requeridos!');
            return back();
        }

        // ======================================================
        // ======================================================

        if(!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        }

        $user = $this->consultarUsuario($usuario);
      
        if(isset($user) && !empty($user) && !is_null($user)) {

            $contarClaveErronea = $user->clave_fallas;

            if($contarClaveErronea >= 4) {
                $this->inactivarUsuario($user->id_usuario);
            }

            if($user->id_estado == 2) {
                alert()->error('Error','Usuario ' . $usuario . ' inactivo, por favor contacte al administrador');
                return back();
            }

            // ==================================

            if( Hash::check($clave, $user->clave) ) {

                $this->crearVariablesSesion($user);
                $this->actualizarClaveFallas($user->id_usuario, 0);

                return redirect()->route('inicio.index');
                
            } else {
                $contarClaveErronea += 1;
                $this->actualizarClaveFallas($user->id_usuario, $contarClaveErronea);
                alert()->error('Error','Credenciales Inválidas');
                return back();
            }
        } elseif ($user == null) {
            alert()->error('Error','Este usuario no existe: ' . $usuario);
            return back();
        } else {
            alert()->error('Error','Error al consultar el usuario. Intente de nuevo.');
            return back();
        }
    }

    // ==================================================
    
    private function crearVariablesSesion($user)
    {
        // Creamos las variables de sesión
        session()->put('id_usuario', $user->id_usuario);
        session()->put('usuario', $user->usuario);
        session()->put('id_rol', $user->id_rol);
        session()->put('sesion_iniciada', true);
    }

    // ======================================================

    private function consultarUsuario($usuario)
    {
        try {
            $response = $this->clientApi->post($this->baseUri.'query_usuario', ['json' => ['usuario' => $usuario]]);
            $respuesta = json_decode($response->getBody()->getContents());

            if(isset($respuesta) && !empty($respuesta)) {
                return $respuesta;
            }
        } catch (Exception $e) {
            alert()->error('Consultando el usuario de inicion de sesión!');
            return back();
        }
    }

    // ======================================================

    private function inactivarUsuario($idUser)
    {
        try {
            $response = $this->clientApi->post($this->baseUri.'inactivar_usuario/'.$idUser,
            [
                'json' => [
                    'id_audit' => $idUser
                ]
            ]);
            json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Inactivando el usuario!');
            return back();
        }
    }

    // ======================================================

    private function actualizarClaveFallas($idUsuario, $contador)
    {
        try {
            $response = $this->clientApi->post($this->baseUri.'actualizar_clave_fallas/'.$idUsuario,
                [
                    'json' => [
                        'clave_fallas' => $contador,
                        'id_audit' => $idUsuario
                    ]
                ]
            );
            json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error actualizando los intentos de inicio de sesión!');
            return back();
        }
    }
}