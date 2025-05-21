<?php

namespace App\Http\Controllers\frecuencias;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\frecuencias\FrecuenciaIndex;
use App\Http\Responsable\frecuencias\FrecuenciaStore;
use App\Http\Responsable\frecuencias\FrecuenciaUpdate;
use App\Http\Responsable\frecuencias\FrecuenciaEdit;
use App\Models\Frecuencia;

class FrecuenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new FrecuenciaIndex();
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new FrecuenciaStore($request);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idFrecuencia)
    {
        return new FrecuenciaEdit($idFrecuencia);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idFrecuencia)
    {
        return new FrecuenciaUpdate($idFrecuencia);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idUsuario)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    public function consultarFrecuencia(Request $request)
    {
        try {
            $frecuenciaInput = $request->input('frecuencia');
        
            // Consultamos si ya existe esta frecuencia
            $frecuencia = Frecuencia::where('frecuencia', $frecuenciaInput)->first();

            if ($frecuencia) {
                return response()->json(['success' => true, 'data' => $frecuencia]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe frecuencia']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
