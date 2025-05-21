<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermisoStore implements Responsable
{
    public function toResponse($request)
    {
        try {
            $namePermission = $request->input('permission');
            $routeName = $request->input('route_name');
            $validarPermision = $this->validarNombrePermiso(ucwords($namePermission));

            if ($validarPermision == 0) {

                $createPermission = Permission::create([
                    'name' => ucwords($namePermission),
                    'guard_name' => 'API',
                    'route_name' => $routeName,
                ]);
    
                if ($createPermission) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Permiso creado correctamente'
                    ]);
                }

            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'El nombre de permiso ya existe en la base de datos'
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    public function validarNombrePermiso($name)
    {
        return Permission::select('name', 'guard_name')
                ->where('name', $name)
                ->count();
    }
}
