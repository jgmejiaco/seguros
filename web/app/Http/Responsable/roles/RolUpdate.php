<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RolUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idRol;

    public function __construct($idRol)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idRol = $idRol;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'rol'   => 'required|string',
            // 'id_estado'     => 'required|integer'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Rol es obligatorio');
            return redirect()->route('ramos.index');
        }

        // Si pasa la validación
        $idRol = $this->idRol;
        $rol = $request->input('rol');
        // $idEstado = $request->input('id_estado');

        // Consultamos si ya existe ese ramo
        $consultarRol = $this->consultarRol($rol);


        // Si existe la aseguradora
        if (isset($consultarRol->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarRol->data->id == $idRol &&
                $consultarRol->data->name == $rol /*&&
                $consultarRol->data->id_estado == $idEstado*/
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('roles.index');
            }

            // Caso 2: Se debe actualizar (solo id_estado cambia)
            if ( $consultarRol->data->id == $idRol && $consultarRol->data->name != $rol
                /*&& $consultarRol->data->id_estado != $idEstado*/
            ) {
                return $this->actualizarRol($idRol, $rol);
            }
        }

        // Caso 3: Si ya existe otra ramo con el mismo nombre
        if ($consultarRol && $consultarRol->success) {
            alert()->warning('Precaución', 'Este Rol ya existe.');
            return back();
        }

        // Si no existe la ramo, la actualizamos
        return $this->actualizarRol($idRol, $rol);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar la aseguradora
    private function consultarRol($rol)
    {
        try {
            $queryRol = $this->clientApi->post($this->baseUri.'consultar_rol', [
                'query' => ['rol' => $rol]
            ]);
            return json_decode($queryRol->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('roles.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar la aseguradora
    private function actualizarRol($idRol, $rol)
    {
        try {
            $peticionRolUpdate = $this->clientApi->put($this->baseUri . 'rol_update/' . $idRol, [
                'json' => [
                    'rol' => ucwords(strtolower(trim($rol))),
                    // 'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resRolUpdate = json_decode($peticionRolUpdate->getBody()->getContents());

            if (isset($resRolUpdate->success) && $resRolUpdate->success) {
                alert()->success('Exito', 'Rol editado satisfactoriamente.');
                return redirect()->route('roles.index');
            }
        } catch (Exception $e) {
            alert()->error('Error editando el Rol, contacte a Soporte.');
            return redirect()->route('roles.index');
        }
    }
}
