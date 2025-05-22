<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\MedioPago;

class MedioPagoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $mediosPago = MedioPago::orderBy('medio_pago')->get();

            return response()->json($mediosPago);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
