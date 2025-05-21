<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Estado;

class EstadoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $estados = Estado::orderBy('estado')->get();

            return response()->json($estados);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
