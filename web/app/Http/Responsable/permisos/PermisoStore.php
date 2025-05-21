<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class PermisoStore implements Responsable
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
        $nombrePermiso = request('nombre_permiso', null);
        $rutaPermiso = request('ruta_permiso', null);

        try {
            $peticionPermissionStore = $this->clientApi->post($this->baseUri . 'permiso_store', [
                'json' => [
                    'permission' => $nombrePermiso,
                    'route_name' => $rutaPermiso,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resPermiso = json_decode($peticionPermissionStore->getBody()->getContents());

            if (isset($resPermiso->success) && $resPermiso->success) {
                alert()->success($resPermiso->message);
                return redirect()->route('permisos.index');
            }

            if (isset($resPermiso->error) && $resPermiso->error) {
                alert()->error($resPermiso->message);
                return redirect()->route('permisos.index');
            }

        } catch (Exception $e) {
            alert()->error("Ocurrió un error creando el permiso!");
            return back();
        }
    } // FIN toResponse($request)
}
