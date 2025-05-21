<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Ramo;

class RamoEdit implements Responsable
{
    protected $idRamo;

    public function __construct($idRamo)
    {
        $this->idRamo = $idRamo;
    }

    public function toResponse($request)
    {
        try {
            $ramo = Ramo::where('id_ramo', $this->idRamo)->orderByDesc('ramo')->first();

            return response()->json($ramo);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
