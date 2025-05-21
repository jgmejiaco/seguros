<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Usuario;

class UsuarioEdit implements Responsable
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function toResponse($request)
    {
        try {
            $usuario = Usuario::where('id_usuario', $this->idUsuario)->orderBy('id_usuario')->first();

            return response()->json($usuario);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
