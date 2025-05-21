<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Frecuencia;

class FrecuenciaEdit implements Responsable
{
    protected $idFrecuencia;

    public function __construct($idFrecuencia)
    {
        $this->idFrecuencia = $idFrecuencia;
    }

    public function toResponse($request)
    {
        try {
            $frecuencia = Frecuencia::where('id_frecuencia', $this->idFrecuencia)->orderByDesc('frecuencia')->first();

            return response()->json($frecuencia);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
