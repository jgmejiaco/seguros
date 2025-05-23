<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Financiera;

class FinancieraStore implements Responsable
{
    public function toResponse($request)
    {
        $financiera = $request->input('financiera');

        // =================================================

        try {
            $nuevaFinanciera = Financiera::create([
                'financiera' => $financiera
            ]);
    
            if ($nuevaFinanciera) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
