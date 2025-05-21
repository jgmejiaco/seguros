<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class PermisoUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idPermiso;

    public function __construct($idPermiso)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idPermiso = $idPermiso;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $nombrePermiso = request('nombre_permiso', null);
        $rutaPermiso = request('ruta_permiso', null);

        try {
            $peticionPermisoUpdate = $this->clientApi->put($this->baseUri . 'permiso_update/'.$this->idPermiso, [
                'json' => [
                    'name' => $nombrePermiso,
                    'route_name' => $rutaPermiso,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resPermisoUpdate = json_decode($peticionPermisoUpdate->getBody()->getContents());

            if (isset($resPermisoUpdate) && $resPermisoUpdate->success) {
                alert()->success('Exito', 'Permiso editado satisfactoriamente.');
                return redirect()->route('permisos.index');
            }
        } catch (Exception $e) {
            alert()->error("Error editandoo el permiso!");
            return back();
        }
    } // FIN toResponse($request)
}
