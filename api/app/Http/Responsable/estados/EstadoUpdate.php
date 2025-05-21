<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Estado;

class EstadoUpdate implements Responsable
{
    protected $idEstado;

    public function __construct($idEstado)
    {
        $this->idEstado = $idEstado;
    }

    public function toResponse($request)
    {
        $estado = Estado::findOrFail($this->idEstado);

        if (isset($estado) && !is_null($estado) && !empty($estado)) {
            try {
                $estado->estado = $request->input('estado');
                $estado->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
