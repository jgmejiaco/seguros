<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FrecuenciaUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idFrecuencia;

    public function __construct($idFrecuencia)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idFrecuencia = $idFrecuencia;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'frecuencia'       => 'required|string',
            'id_estado'         => 'required|integer'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Frecuencia es obligatoria');
            return redirect()->route('frecuencias.index');
        }

        // Si pasa la validación
        $idFrecuencia = $this->idFrecuencia;
        $frecuencia = $request->input('frecuencia');
        $idEstado = $request->input('id_estado');

        // Consultamos si ya existe esa frecuencia
        $consultarFrecuencia = $this->consultarFrecuencia($frecuencia);


        // Si existe la aseguradora
        if (isset($consultarFrecuencia->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarFrecuencia->data->id_frecuencia == $idFrecuencia &&
                $consultarFrecuencia->data->frecuencia == $frecuencia &&
                $consultarFrecuencia->data->id_estado == $idEstado
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('frecuencias.index');
            }

            // Caso 2: Se debe actualizar (solo id_estado cambia)
            if (
                ($consultarFrecuencia->data->id_frecuencia == $idFrecuencia) &&
                ($consultarFrecuencia->data->frecuencia != $frecuencia ||
                $consultarFrecuencia->data->id_estado != $idEstado)
            ) {
                return $this->actualizarFrecuencia($idFrecuencia, $frecuencia, $idEstado);
            }
        }

        // Caso 3: Si ya existe otra aseguradora con el mismo nombre
        if ($consultarFrecuencia && $consultarFrecuencia->success) {
            alert()->warning('Precaución', 'Esta frecuencia ya existe.');
            return back();
        }

        // Si no existe la frecuencia, la actualizamos
        return $this->actualizarFrecuencia($idFrecuencia, $frecuencia, $idEstado);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar la aseguradora
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

    // ===================================================================
    // ===================================================================

    // Método para actualizar la aseguradora
    private function actualizarFrecuencia($idFrecuencia, $frecuencia, $idEstado)
    {
        try {
            $peticionFrecuenciaUpdate = $this->clientApi->put($this->baseUri . 'frecuencia_update/' . $idFrecuencia, [
                'json' => [
                    'frecuencia' => ucwords(strtolower(trim($frecuencia))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resFrecuenciaUpdate = json_decode($peticionFrecuenciaUpdate->getBody()->getContents());

            if (isset($resFrecuenciaUpdate->success) && $resFrecuenciaUpdate->success) {
                alert()->success('Exito', 'Frecuencia editada satisfactoriamente.');
                return redirect()->route('frecuencias.index');
            }
        } catch (Exception $e) {
            alert()->error('Error editando la frecuencia, contacte a Soporte.');
            return redirect()->route('frecuencias.index');
        }
    }
}
