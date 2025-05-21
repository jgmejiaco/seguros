<?php

namespace App\Http\Controllers\asignar_permisos;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\asignar_permisos\AsignarPermisoIndex;
use App\Http\Responsable\asignar_permisos\AsignarPermisoStore;
use App\Models\Permission;
use App\Models\ModelHasPermissions;
use App\Models\RoleHasPermission;
use App\Models\ModelHasRoles;

class AsignarPermisosController extends Controller
{
    public function index()
    {
        return new AsignarPermisoIndex();
    }

    public function store(Request $request)
    {
        return new AsignarPermisoStore();
    }

    function consultarPermisosRol(Request $request)
    {
        try {
            $idRol = $request->input('id_rol');

            // 2. Obtener los permisos asociados a esos roles
            $permisos = RoleHasPermission::where('role_id', $idRol)->pluck('permission_id');

            return response()->json(['permisos' => $permisos]);
            
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
} // FIN Class AsignarPermisosController
