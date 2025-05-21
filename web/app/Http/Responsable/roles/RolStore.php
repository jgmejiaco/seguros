<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RolStore implements Responsable
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
            'rol' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Rol es obligatoria');
            return redirect()->route('roles.index');
        }

        // Si pasa la validación
        $rol = $request->input('rol');
        // $idEstado = 1;

        // Consultamos si ya existe esa aseguradora
        $consultarRol = $this->consultarRol($rol);
        
        if($consultarRol && $consultarRol->success) {
            alert()->info('Info', 'Este Rol ya existe.');
            return back();
        }

        try {
            $peticionRolStore = $this->clientApi->post($this->baseUri . 'rol_store', [
                'json' => [
                    'rol' => ucwords(strtolower(trim($rol))),
                    // 'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resRolStore = json_decode($peticionRolStore->getBody()->getContents());
            
            if (isset($resRolStore->success) && $resRolStore->success === true) {
                alert()->success('Éxito', 'Rol creado satisfactoriamente');
                return redirect()->route('roles.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('roles.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

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
}
