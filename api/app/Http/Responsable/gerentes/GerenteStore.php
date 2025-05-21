<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Gerente;

class GerenteStore implements Responsable
{
    public function toResponse($request)
    {
        $gerente = $request->input('gerente');
        $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevaGerente = Gerente::create([
                'gerente' => $gerente,
                'id_estado' => $idEstado
            ]);
    
            if ($nuevaGerente) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
