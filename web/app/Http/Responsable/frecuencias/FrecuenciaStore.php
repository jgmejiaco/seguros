<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FrecuenciaStore implements Responsable
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
            'frecuencia' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Frecuencia es obligatoria');
            return redirect()->route('frecuencias.index');
        }

        // Si pasa la validación
        $frecuencia = $request->input('frecuencia');
        $idEstado = 1;

        // Consultamos si ya existe esa aseguradora
        $consultarFrecuencia = $this->consultarFrecuencia($frecuencia);
        
        if($consultarFrecuencia && $consultarFrecuencia->success) {
            alert()->info('Info', 'Esta frecuencia ya existe.');
            return back();
        }

        try {
            $peticionFrecuenciaStore = $this->clientApi->post($this->baseUri . 'frecuencia_store', [
                'json' => [
                    'frecuencia' => ucwords(strtolower(trim($frecuencia))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resFrecuenciaStore = json_decode($peticionFrecuenciaStore->getBody()->getContents());
            
            if (isset($resFrecuenciaStore->success) && $resFrecuenciaStore->success === true) {
                alert()->success('Éxito', 'Frecuencia creada satisfactoriamente');
                return redirect()->route('frecuencias.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('frecuencias.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarFrecuencia($frecuencia)
    {
        try {
            $queryFrecuencia = $this->clientApi->post($this->baseUri.'consultar_frecuencia', [
                'query' => ['frecuencia' => $frecuencia]
            ]);
            return json_decode($queryFrecuencia->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('frecuencias.index');
        }
    }
}
