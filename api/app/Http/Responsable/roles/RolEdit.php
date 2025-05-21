<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Rol;

class RolEdit implements Responsable
{
    protected $idRol;

    public function __construct($idRol)
    {
        $this->idRol = $idRol;
    }

    public function toResponse($request)
    {
        try {
            $rol = Rol::where('id', $this->idRol)->orderByDesc('name')->first();

            return response()->json($rol);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
