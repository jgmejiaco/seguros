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

        if(isset($user) && !is_null($user) && $user != 'error_exception') {

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
        } elseif ($user == null && $user != 'error_exception') {
            alert()->error('Error','Este usuario no existe: ' . $usuario);
            return back();
        } else {
            return view('db_conexion');
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
            $peticion = $this->clientApi->post($this->baseUri.'query_usuario', ['json' => ['usuario' => $usuario]]);
            $resUsuario = json_decode($peticion->getBody()->getContents());

            // Verifica si contiene un error
            if (is_object($resUsuario) && property_exists($resUsuario, 'error_exception')) {
                return 'error_exception';
            }

            return $resUsuario;

        } catch (Exception $e) {
            return 'error_exception';
        }
    }

    // ======================================================

    private function inactivarUsuario($idUser)
    {
        try {
            $response = $this->clientApi->post($this->baseUri.'inactivar_usuario/'.$idUser,
            [
                'headers' => [
                    'User-Agent' => request()->header('User-Agent'),
                ],
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
                    'headers' => [
                        'User-Agent' => request()->header('User-Agent'),
                    ],
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
