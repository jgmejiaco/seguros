<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Gerente;

class GerenteUpdate implements Responsable
{
    protected $idGerente;

    public function __construct($idGerente)
    {
        $this->idGerente = $idGerente;
    }

    public function toResponse($request)
    {
        $gerente = Gerente::findOrFail($this->idGerente);

        if (isset($gerente) && !is_null($gerente) && !empty($gerente)) {
            try {
                $gerente->gerente = $request->input('gerente');
                $gerente->id_estado = $request->input('id_estado');
                $gerente->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
