<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\LineaPersonal;

class LineaPersonalDestroy implements Responsable
{
    protected $idLineasPersonal;

    public function __construct($idLineasPersonal)
    {
        $this->idLineasPersonal = $idLineasPersonal;
    }

    public function toResponse($request)
    {
        $radicado = LineaPersonal::findOrFail($this->idLineasPersonal);

        try {
            $archivos = [];

            if ($radicado) {

                $camposArchivos = [
                    'file_cedula', 'file_matricula', 'file_asegurabilidad',
                    'file_sarlaft', 'file_caratula_poliza', 'file_renovacion', 'file_otros'
                ];

                foreach ($camposArchivos as $campo) {
                    if (!empty($radicado->$campo)) {
                        $archivos[] = $radicado->$campo;
                    }
                }

                $radicado->forceDelete();
    
                // forceDelete() es para eliminiar todo el registro ignorando el solfdelete deleted_at
                // delete() es para softdelete en deleted_at
                // destroy() no aplica
            }

            return response()->json([
                'success' => true,
                'archivos' => $archivos, // Devuelve las rutas
            ]);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()]);
        }
    }
}
