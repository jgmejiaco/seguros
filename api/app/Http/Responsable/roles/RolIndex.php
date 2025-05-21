<?php

namespace App\Http\Responsable\roles;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Rol;

class RolIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            // $roles = Ramo::leftJoin('estados', 'estados.id_estado', '=', 'roles.id_estado')
            //     ->select(
            //         'id_ramo',
            //         'ramo',
            //         'estados.id_estado',
            //         'estados.estado',
            //     )
            //     ->orderBy('ramo')
            //     ->get();

            $roles = Rol::select(
                    'id as id_rol',
                    'name as rol'
                )
                ->orderBy('name')
                ->get();

            return response()->json($roles);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
