<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioUpdate implements Responsable
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function toResponse($request)
    {
        $usuario = Usuario::findOrFail($this->idUsuario);

        if (isset($usuario) && !is_null($usuario) && !empty($usuario)) {
            try {
                $usuario->nombre_usuario = $request->input('nombre_usuario');
                $usuario->apellido_usuario = $request->input('apellido_usuario');
                $usuario->correo = $request->input('correo');
                $usuario->id_rol = $request->input('id_rol');
                $usuario->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()]);
            }
        }
    }
}
