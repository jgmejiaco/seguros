<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Permission;

class PermisoUpdate implements Responsable
{
    protected $idPermiso;

    public function __construct($idPermiso)
    {
        $this->idPermiso = $idPermiso;
    }

    public function toResponse($request)
    {
        $permiso = Permission::findOrFail($this->idPermiso);

        // =================================================

        if (isset($permiso) && !is_null($permiso) && !empty($permiso)) {
            try {
                $permiso->name = $request->input('name');
                $permiso->route_name = $request->input('route_name');
                $permiso->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
