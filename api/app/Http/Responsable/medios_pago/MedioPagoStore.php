<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\MedioPago;

class MedioPagoStore implements Responsable
{
    public function toResponse($request)
    {
        $medioPago = $request->input('medio_pago');

        // =================================================

        try {
            $nuevaEstado = MedioPago::create([
                'medio_pago' => $medioPago
            ]);
    
            if ($nuevaEstado) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
