<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class MedioPagoEdit implements Responsable
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
        try {
            $peticionMedioPagoEdit = $this->clientApi->get($this->baseUri . 'medio_pago_edit/' . $this->idMedioPago, [
                'json' => []
            ]);
            $resMedioPagoEdit = json_decode($peticionMedioPagoEdit->getBody()->getContents());

            if (isset($resMedioPagoEdit)) {
                return view('medios_pago.modal_editar_medio_pago', compact('resMedioPagoEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error editando el Medio de Pago, contacte a Soporte.');
            return redirect()->route('medios_pago.index');
        }
    } // FIN toResponse($request)
} // FIN Class EstadoEdit
