<?php

namespace App\Http\Responsable\asignar_permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\RoleHasPermission;

class AsignarPermisoStore implements Responsable
{
    public function toResponse($request)
    {
        try {
            $permisos = $request->input('permissions');
            $idRol = $request->input('id_rol');

            // Borrar permisos actuales del rol
            RoleHasPermission::where('role_id', $idRol)->delete();

            foreach ($permisos as $permisoId) {
                RoleHasPermission::updateOrCreate([
                    'permission_id' => $permisoId,
                    'role_id' => $idRol
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Permisos asignados correctamente'
            ]);
            
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
