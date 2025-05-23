<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Financiera;

class FinancieraEdit implements Responsable
{
    protected $idFinanciera;

    public function __construct($idFinanciera)
    {
        $this->idFinanciera = $idFinanciera;
    }

    public function toResponse($request)
    {
        try {
            $financiera = Financiera::where('id_financiera', $this->idFinanciera)->orderByDesc('financiera')->first();

            return response()->json($financiera);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
