<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class PermisoEdit implements Responsable
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
        $idPermiso = $this->idPermiso;
        
        // =============================================================

        try {
            $peticionPermisoEdit = $this->clientApi->get($this->baseUri . 'permiso_edit/'.$idPermiso, [
                'json' => []
            ]);
            $resPermisoEdit = json_decode($peticionPermisoEdit->getBody()->getContents());

            if (isset($resPermisoEdit)) {
                return view('permisos.modal_editar_permiso', compact('resPermisoEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error consultando el permiso, contacte a Soporte.');
            return redirect()->route('permisos.index');
        }
    } // FIN toResponse($request)
}
