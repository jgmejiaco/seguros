<?php

namespace App\Http\Responsable\asignar_permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class AsignarPermisoStore implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    public function toResponse($request)
    {
        try {
            $idRol = request('id_rol', null);
            $arrayPermisos = request('permisos', null);

            if(!isset($idRol) || is_null($idRol) || empty($idRol)) {
                alert()->error("El campo Rol es obligatorio");
                return back();
            }

            if(isset($arrayPermisos) && !is_null($arrayPermisos) && !empty($arrayPermisos)) {
                $peticionPermisoStore = $this->clientApi->post($this->baseUri . 'asignar_permiso_rol',
                [
                    'json' => [
                        'permissions' => $arrayPermisos,
                        'id_rol' => $idRol,
                        'id_audit' => session('id_usuario')
                    ]
                ]);
    
                $permission = json_decode($peticionPermisoStore->getBody()->getContents());

                if(isset($permission->success) && $permission->success) {
                    alert()->success($permission->message);
                    return redirect()->route('asignar_permisos.index');
                }

            } else {
                alert()->error("Debes seleccionar al menos un permiso");
                return back();
            }

        } catch (Exception $e) {
            alert()->error("Ha ocurrido un error asignando los permisos!");
            return back();
        }
    }
}
