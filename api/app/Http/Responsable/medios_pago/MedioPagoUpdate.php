<?php

namespace App\Http\Responsable\medios_pago;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\MedioPago;

class MedioPagoUpdate implements Responsable
{
    protected $idMedioPago;

    public function __construct($idMedioPago)
    {
        $this->idMedioPago = $idMedioPago;
    }

    public function toResponse($request)
    {
        $medioPago = MedioPago::findOrFail($this->idMedioPago);

        if (isset($medioPago) && !is_null($medioPago) && !empty($medioPago)) {
            try {
                $medioPago->medio_pago = $request->input('medio_pago');
                $medioPago->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
