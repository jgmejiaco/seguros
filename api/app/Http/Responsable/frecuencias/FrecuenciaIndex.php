<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Frecuencia;

class FrecuenciaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $frecuencias = Frecuencia::leftJoin('estados', 'estados.id_estado', '=', 'frecuencias.id_estado')
                ->select(
                    'id_frecuencia',
                    'frecuencia',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('frecuencia')
                ->get();

            return response()->json($frecuencias);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
