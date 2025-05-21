<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Consultor;

class ConsultorIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $consultores = Consultor::leftJoin('estados', 'estados.id_estado', '=', 'consultores.id_estado')
                ->select(
                    'id_consultor',
                    'clave_consultor_global',
                    'consultor',
                    'gerente_comercial',
                    'lider_comercial',
                    'equipo_informes',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('consultor','asc')
                ->get();

            return response()->json($consultores);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
