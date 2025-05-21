<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Frecuencia;

class FrecuenciaUpdate implements Responsable
{
    protected $idFrecuencia;

    public function __construct($idFrecuencia)
    {
        $this->idFrecuencia = $idFrecuencia;
    }

    public function toResponse($request)
    {
        $frecuencia = Frecuencia::findOrFail($this->idFrecuencia);

        if (isset($frecuencia) && !is_null($frecuencia) && !empty($frecuencia)) {
            try {
                $frecuencia->frecuencia = $request->input('frecuencia');
                $frecuencia->id_estado = $request->input('id_estado');
                $frecuencia->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
