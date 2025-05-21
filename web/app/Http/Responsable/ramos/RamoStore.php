<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RamoStore implements Responsable
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
            'ramo' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Ramo es obligatoria');
            return redirect()->route('ramos.index');
        }

        // Si pasa la validación
        $ramo = $request->input('ramo');
        $idEstado = 1;

        // Consultamos si ya existe esa aseguradora
        $consultarRamo = $this->consultarRamo($ramo);
        
        if($consultarRamo && $consultarRamo->success) {
            alert()->info('Info', 'Este Ramo ya existe.');
            return back();
        }

        try {
            $peticionRamoStore = $this->clientApi->post($this->baseUri . 'ramo_store', [
                'json' => [
                    'ramo' => ucwords(strtolower(trim($ramo))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resRamoStore = json_decode($peticionRamoStore->getBody()->getContents());
            
            if (isset($resRamoStore->success) && $resRamoStore->success === true) {
                alert()->success('Éxito', 'Ramo creado satisfactoriamente');
                return redirect()->route('ramos.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('ramos.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarRamo($ramo)
    {
        try {
            $queryRamo = $this->clientApi->post($this->baseUri.'consultar_ramo', [
                'query' => ['ramo' => $ramo]
            ]);
            return json_decode($queryRamo->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('ramos.index');
        }
    }
}
