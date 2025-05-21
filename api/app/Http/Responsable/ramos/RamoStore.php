<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Ramo;

class RamoStore implements Responsable
{
    public function toResponse($request)
    {
        $ramo = $request->input('ramo');
        $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevaRamo = Ramo::create([
                'ramo' => $ramo,
                'id_estado' => $idEstado
            ]);
    
            if ($nuevaRamo) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
