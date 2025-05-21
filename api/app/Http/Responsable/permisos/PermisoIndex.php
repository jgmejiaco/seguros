<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Permission;

class PermisoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $permisos = Permission::orderBy('name')->get();

            return response()->json($permisos);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
