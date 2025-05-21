<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Estado;

class EstadoEdit implements Responsable
{
    protected $idEstado;

    public function __construct($idEstado)
    {
        $this->idEstado = $idEstado;
    }

    public function toResponse($request)
    {
        try {
            $estado = Estado::where('id_estado', $this->idEstado)->orderByDesc('estado')->first();

            return response()->json($estado);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
