<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Frecuencia;

class FrecuenciaStore implements Responsable
{
    public function toResponse($request)
    {
        $frecuencia = $request->input('frecuencia');
        $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevaFrecuencia = Frecuencia::create([
                'frecuencia' => $frecuencia,
                'id_estado' => $idEstado
            ]);
    
            if ($nuevaFrecuencia) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
