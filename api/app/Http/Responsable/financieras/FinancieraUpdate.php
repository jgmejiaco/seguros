<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Financiera;

class FinancieraUpdate implements Responsable
{
    protected $idFinanciera;

    public function __construct($idFinanciera)
    {
        $this->idFinanciera = $idFinanciera;
    }

    public function toResponse($request)
    {
        $financiera = Financiera::findOrFail($this->idFinanciera);

        if (isset($financiera) && !is_null($financiera) && !empty($financiera)) {
            try {
                $financiera->financiera = $request->input('financiera');
                $financiera->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
