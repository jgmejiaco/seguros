<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RamoUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idRamo;

    public function __construct($idRamo)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idRamo = $idRamo;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'ramo'          => 'required|string',
            'id_estado'     => 'required|integer'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Ramo es obligatorio');
            return redirect()->route('ramos.index');
        }

        // Si pasa la validación
        $idRamo = $this->idRamo;
        $ramo = $request->input('ramo');
        $idEstado = $request->input('id_estado');

        // Consultamos si ya existe ese ramo
        $consultarRamo = $this->consultarRamo($ramo);


        // Si existe la aseguradora
        if (isset($consultarRamo->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarRamo->data->id_ramo == $idRamo &&
                $consultarRamo->data->ramo == $ramo &&
                $consultarRamo->data->id_estado == $idEstado
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('ramos.index');
            }

            // Caso 2: Se debe actualizar (solo id_estado cambia)
            if (
                ($consultarRamo->data->id_ramo == $idRamo) &&
                ($consultarRamo->data->ramo != $ramo ||
                $consultarRamo->data->id_estado != $idEstado)
            ) {
                return $this->actualizarRamo($idRamo, $ramo, $idEstado);
            }
        }

        // Caso 3: Si ya existe otra ramo con el mismo nombre
        if ($consultarRamo && $consultarRamo->success) {
            alert()->warning('Precaución', 'Este ramo ya existe.');
            return back();
        }

        // Si no existe la ramo, la actualizamos
        return $this->actualizarRamo($idRamo, $ramo, $idEstado);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar la aseguradora
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

    // ===================================================================
    // ===================================================================

    // Método para actualizar la aseguradora
    private function actualizarRamo($idRamo, $ramo, $idEstado)
    {
        try {
            $peticionRamoUpdate = $this->clientApi->put($this->baseUri . 'ramo_update/' . $idRamo, [
                'json' => [
                    'ramo' => ucwords(strtolower(trim($ramo))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resRamoUpdate = json_decode($peticionRamoUpdate->getBody()->getContents());

            if (isset($resRamoUpdate->success) && $resRamoUpdate->success) {
                alert()->success('Exito', 'Ramo editado satisfactoriamente.');
                return redirect()->route('ramos.index');
            }
        } catch (Exception $e) {
            alert()->error('Error editando el ramo, contacte a Soporte.');
            return redirect()->route('ramos.index');
        }
    }
}
