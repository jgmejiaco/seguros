<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Aseguradora;

class AseguradoraIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $aseguradoras = Aseguradora::leftJoin('estados', 'estados.id_estado', '=', 'aseguradoras.id_estado')
                ->select(
                    'id_aseguradora',
                    'aseguradora',
                    'nit_aseguradora',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('aseguradora')
                ->get();

            return response()->json($aseguradoras);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
