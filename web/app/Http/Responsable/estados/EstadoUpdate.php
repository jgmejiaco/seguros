<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class EstadoUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idEstado;

    public function __construct($idEstado)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idEstado = $idEstado;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'estado'    => 'required|string'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Estado es obligatorio');
            return redirect()->route('estados.index');
        }

        // Si pasa la validación
        $idEstado = $this->idEstado;
        $estado = $request->input('estado');

        // Consultamos si ya existe ese estado
        $consultarEstado = $this->consultarEstado($estado);


        // Si existe la aseguradora
        if (isset($consultarEstado->data)) {

            // Caso 1: No hay cambios
            if ($consultarEstado->data->id_estado == $idEstado && $consultarEstado->data->estado == $estado) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('estados.index');
            }

            // Caso 2: Se debe actualizar (solo estado cambia)
            if ($consultarEstado->data->id_estado == $idEstado && $consultarEstado->data->estado != $estado) {
                return $this->actualizarEstado($idEstado, $estado);
            }
        }

        // Caso 3: Si ya existe otra aseguradora con el mismo nombre
        if ($consultarEstado && $consultarEstado->success) {
            alert()->warning('Precaución', 'Este Esatdo ya existe.');
            return back();
        }

        // Si no existe el estado, la actualizamos
        return $this->actualizarEstado($idEstado, $estado);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar el estado
    private function consultarEstado($estado)
    {
        try {
            $queryEstado = $this->clientApi->post($this->baseUri.'consultar_estado', [
                'query' => ['estado' => $estado]
            ]);
            return json_decode($queryEstado->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('estados.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar el estado
    private function actualizarEstado($idEstado, $estado)
    {
        try {
            $peticionEstadoUpdate = $this->clientApi->put($this->baseUri . 'estado_update/' . $idEstado, [
                'json' => [
                    'estado' => ucwords(strtolower(trim($estado))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resEstadoUpdate = json_decode($peticionEstadoUpdate->getBody()->getContents());

            if (isset($resEstadoUpdate->success) && $resEstadoUpdate->success) {
                alert()->success('Exito', 'Estado editado satisfactoriamente.');
                return redirect()->route('estados.index');
            }
        } catch (Exception $e) {
            alert()->error('Error editando el estado, contacte a Soporte.');
            return redirect()->route('estados.index');
        }
    }
}
