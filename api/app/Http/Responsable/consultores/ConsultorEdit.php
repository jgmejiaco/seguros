<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Consultor;

class ConsultorEdit implements Responsable
{
    protected $idConsultor;

    public function __construct($idConsultor)
    {
        $this->idConsultor = $idConsultor;
    }

    public function toResponse($request)
    {
        $consultorInput = $this->idConsultor;

        try {
            $consultor = Consultor::leftJoin('estados', 'estados.id_estado', '=', 'consultores.id_estado')
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
                ->where('id_consultor', $consultorInput)
                // ->orderBy('consultor','asc')
                ->first();

            return response()->json($consultor);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
