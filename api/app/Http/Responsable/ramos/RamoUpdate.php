<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Ramo;

class RamoUpdate implements Responsable
{
    protected $idRamo;

    public function __construct($idRamo)
    {
        $this->idRamo = $idRamo;
    }

    public function toResponse($request)
    {
        $ramo = Ramo::findOrFail($this->idRamo);

        if (isset($ramo) && !is_null($ramo) && !empty($ramo)) {
            try {
                $ramo->ramo = $request->input('ramo');
                $ramo->id_estado = $request->input('id_estado');
                $ramo->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
