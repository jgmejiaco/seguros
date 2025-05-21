<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Ramo;

class RamoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $ramos = Ramo::leftJoin('estados', 'estados.id_estado', '=', 'ramos.id_estado')
                ->select(
                    'id_ramo',
                    'ramo',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('ramo')
                ->get();

            return response()->json($ramos);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
