<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\MedioPago;

class MedioPagoEdit implements Responsable
{
    protected $idMedioPago;

    public function __construct($idMedioPago)
    {
        $this->idMedioPago = $idMedioPago;
    }

    public function toResponse($request)
    {
        try {
            $medioPago = MedioPago::where('id_medio_pago', $this->idMedioPago)->orderByDesc('medio_pago')->first();

            return response()->json($medioPago);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
