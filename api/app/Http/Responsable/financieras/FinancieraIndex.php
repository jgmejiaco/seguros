<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Financiera;

class FinancieraIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $financieras = Financiera::orderBy('financiera')->get();

            return response()->json($financieras);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
