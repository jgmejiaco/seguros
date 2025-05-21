<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Rol;

class RolUpdate implements Responsable
{
    protected $idRol;

    public function __construct($idRol)
    {
        $this->idRol = $idRol;
    }

    public function toResponse($request)
    {
        $rol = Rol::findOrFail($this->idRol);

        if (isset($rol) && !is_null($rol) && !empty($rol)) {
            try {
                $rol->name = $request->input('rol');
                // $rol->id_estado = $request->input('id_estado');
                $rol->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
