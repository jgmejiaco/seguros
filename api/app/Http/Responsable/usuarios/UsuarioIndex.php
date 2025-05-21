<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $usuarios = Usuario::leftjoin('roles', 'roles.id', '=', 'usuarios.id_rol')
                ->leftjoin('estados', 'estados.id_estado', '=', 'usuarios.id_estado')
                ->select(
                    'id_usuario',
                    'nombre_usuario',
                    'apellido_usuario',
                    DB::raw("CONCAT(nombre_usuario, ' ', apellido_usuario) AS nombre_completo"),
                    'correo',
                    'estado',
                    'usuarios.id_estado',
                    'name',
                    'usuarios.id_rol',
                    'usuario'
                )
                ->orderBy('nombre_completo')
                ->get();

            return response()->json($usuarios);
            
        } catch (Exception $e) {
            return response()->json(['error_bd' => $e->getMessage()]);
        }
    }
}
