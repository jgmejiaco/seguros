<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RolEdit implements Responsable
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
        try {
            $peticionRolEdit = $this->clientApi->get($this->baseUri . 'rol_edit/' . $this->idRol, [
                'json' => []
            ]);
            $resRolEdit = json_decode($peticionRolEdit->getBody()->getContents());

            return view('roles.modal_editar_rol', compact('resRolEdit'));

        } catch (Exception $e) {
            alert()->error('Error consultando el Rol, contacte a Soporte.');
            return redirect()->route('roles.index');
        }
    }
}
