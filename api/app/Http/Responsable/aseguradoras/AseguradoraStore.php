<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Aseguradora;

class AseguradoraStore implements Responsable
{
    public function toResponse($request)
    {
        $aseguradora = $request->input('aseguradora');
        $nitAseguradora = $request->input('nit_aseguradora');
        $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevaAseguradora = Aseguradora::create([
                'aseguradora' => $aseguradora,
                'nit_aseguradora' => $nitAseguradora,
                'id_estado' => $idEstado
            ]);
    
            if ($nuevaAseguradora) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
