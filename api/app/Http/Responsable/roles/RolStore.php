<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;

class RolStore implements Responsable
{
    public function toResponse($request)
    {
        $rol = $request->input('rol');
        // $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevoRol = Rol::create([
                'name' => ucwords($rol),
                'guard_name' => 'API'
                // 'id_estado' => $idEstado
            ]);
    
            if ($nuevoRol) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
