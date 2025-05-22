<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class MedioPagoUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idMedioPago;

    public function __construct($idMedioPago)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idMedioPago = $idMedioPago;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'medio_pago'    => 'required|string'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Medio de Pago es obligatorio');
            return redirect()->route('medios_pago.index');
        }

        // Si pasa la validación
        $idMedioPago = $this->idMedioPago;
        $medioPago = $request->input('medio_pago');

        // Consultamos si ya existe ese estado
        $consultarMedioPago = $this->consultarMedioPago($medioPago);


        // Si existe la aseguradora
        if (isset($consultarMedioPago->data)) {

            // Caso 1: No hay cambios
            if ($consultarMedioPago->data->id_medio_pago == $idMedioPago && $consultarMedioPago->data->medio_pago == $medioPago) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('medios_pago.index');
            }

            // Caso 2: Se debe actualizar (solo estado cambia)
            if ($consultarMedioPago->data->id_medio_pago == $idMedioPago && $consultarMedioPago->data->medio_pago != $medioPago) {
                return $this->actualizarMedioPago($idMedioPago, $medioPago);
            }
        }

        // Caso 3: Si ya existe otra aseguradora con el mismo nombre
        if ($consultarMedioPago && $consultarMedioPago->success) {
            alert()->warning('Precaución', 'Este Medio de Pago ya existe.');
            return back();
        }

        // Si no existe el estado, la actualizamos
        return $this->actualizarMedioPago($idMedioPago, $medioPago);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar el estado
    private function consultarMedioPago($medioPago)
    {
        try {
            $queryMedioPago = $this->clientApi->post($this->baseUri.'consultar_medio_pago', [
                'query' => ['medio_pago' => $medioPago]
            ]);
            return json_decode($queryMedioPago->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando en Medio de Pago, contacte a Soporte.');
            return redirect()->route('medios_pago.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar el estado
    private function actualizarMedioPago($idMedioPago, $medioPago)
    {
        try {
            $peticionMedioPagoUpdate = $this->clientApi->put($this->baseUri . 'medio_pago_update/' . $idMedioPago, [
                'json' => [
                    'medio_pago' => ucwords(strtolower(trim($medioPago))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resMedioPagoUpdate = json_decode($peticionMedioPagoUpdate->getBody()->getContents());

            if (isset($resMedioPagoUpdate->success) && $resMedioPagoUpdate->success) {
                alert()->success('Exito', 'Medio de Pago editado satisfactoriamente.');
                return redirect()->route('medios_pago.index');
            }
        } catch (Exception $e) {
            alert()->error('Error actualizando el Medio de Pago, contacte a Soporte.');
            return redirect()->route('medios_pago.index');
        }
    }
}
