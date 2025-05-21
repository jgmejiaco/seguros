<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Aseguradora;

class AseguradoraUpdate implements Responsable
{
    protected $idAseguradora;

    public function __construct($idAseguradora)
    {
        $this->idAseguradora = $idAseguradora;
    }

    public function toResponse($request)
    {
        $aseguradora = Aseguradora::findOrFail($this->idAseguradora);

        if (isset($aseguradora) && !is_null($aseguradora) && !empty($aseguradora)) {
            try {
                $aseguradora->aseguradora = $request->input('aseguradora');
                $aseguradora->nit_aseguradora = $request->input('nit_aseguradora');
                $aseguradora->id_estado = $request->input('id_estado');
                $aseguradora->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
