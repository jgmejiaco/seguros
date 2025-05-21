<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Aseguradora;

class AseguradoraEdit implements Responsable
{
    protected $idAseguradora;

    public function __construct($idAseguradora)
    {
        $this->idAseguradora = $idAseguradora;
    }

    public function toResponse($request)
    {
        try {
            $aseguradora = Aseguradora::where('id_aseguradora', $this->idAseguradora)->orderByDesc('aseguradora')->first();

            return response()->json($aseguradora);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
