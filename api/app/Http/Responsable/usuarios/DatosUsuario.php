<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class DatosUsuario implements Responsable
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function toResponse($request)
    {
        try {
            $usuario = Usuario::leftjoin('roles', 'roles.id', '=', 'usuarios.id_rol')
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
                ->where('id_usuario', $this->idUsuario)
                ->orderBy('nombre_completo')
                ->first();

            return response()->json($usuario);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()]);
        }
    }
}
