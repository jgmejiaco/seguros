<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Gerente;

class GerenteIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $gerentes = Gerente::leftJoin('estados', 'estados.id_estado', '=', 'gerentes.id_estado')
                ->select(
                    'id_gerente',
                    'gerente',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('gerente')
                ->get();

            return response()->json($gerentes);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
