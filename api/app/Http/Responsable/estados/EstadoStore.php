<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Estado;

class EstadoStore implements Responsable
{
    public function toResponse($request)
    {
        $estado = $request->input('estado');

        // =================================================

        try {
            $nuevaEstado = Estado::create([
                'estado' => $estado
            ]);
    
            if ($nuevaEstado) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
