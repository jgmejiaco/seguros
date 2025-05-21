<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioDestroy implements Responsable
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function toResponse($request)
    {
        $usuario = Usuario::findOrFail($this->idUsuario);
        $idEstado = $usuario->id_estado;

        if (isset($usuario) && !is_null($usuario) && !empty($usuario)) {
            try {
                if ($idEstado == 1) {
                    $usuario->id_estado = 2;
                } else {
                    $usuario->id_estado = 1;
                }

                $usuario->save();
    
                return response()->json(['success' => true]);

            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()]);
            }
        }
    }
}
