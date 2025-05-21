<?php

namespace App\Http\Responsable\permisos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Permission;

class PermisoEdit implements Responsable
{
    protected $idPermiso;

    public function __construct($idPermiso)
    {
        $this->idPermiso = $idPermiso;
    }

    public function toResponse($request)
    {
        try {
            $permiso = Permission::where('id', $this->idPermiso)->first();

            return response()->json($permiso);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
