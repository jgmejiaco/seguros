<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class MedioPagoStore implements Responsable
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
            'medio_pago' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Medio de Pago es obligatorio');
            return redirect()->route('medios_pago.index');
        }

        // Si pasa la validación
        $medioPago = $request->input('medio_pago');

        // Consultamos si ya existe esa aseguradora
        $consultarMedioPago = $this->consultarMedioPago($medioPago);
        
        if($consultarMedioPago && $consultarMedioPago->success) {
            alert()->info('Info', 'Este Medio de Pago ya existe.');
            return back();
        }

        try {
            $peticionMedioPagoStore = $this->clientApi->post($this->baseUri . 'medio_pago_store', [
                'json' => [
                    'medio_pago' => ucwords(strtolower(trim($medioPago))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resMedioPagoStore = json_decode($peticionMedioPagoStore->getBody()->getContents());
            
            if (isset($resMedioPagoStore->success) && $resMedioPagoStore->success === true) {
                alert()->success('Éxito', 'Medio de Pago creado satisfactoriamente');
                return redirect()->route('medios_pago.index');
            }
        } catch (Exception $e) {
            alert()->error('Error creando el Medio de Pago, contacte a Soporte.');
            return redirect()->route('medios_pago.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarMedioPago($medioPago)
    {
        try {
            $queryMedioPago = $this->clientApi->post($this->baseUri.'consultar_medio_pago', [
                'query' => ['medio_pago' => $medioPago]
            ]);
            return json_decode($queryMedioPago->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, consultando el Medio de Pago, contacte a Soporte.');
            return redirect()->route('medios_pago.index');
        }
    }
}
