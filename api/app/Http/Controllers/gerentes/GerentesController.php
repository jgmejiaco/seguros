<?php

namespace App\Http\Controllers\gerentes;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\gerentes\GerenteIndex;
use App\Http\Responsable\gerentes\GerenteStore;
use App\Http\Responsable\gerentes\GerenteUpdate;
use App\Models\Gerente;

class GerentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new GerenteIndex();
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
        return new GerenteStore($request);
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
    public function edit(string $id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idGerente)
    {
        return new GerenteUpdate($idGerente);
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

    public function consultarGerente(Request $request)
    {
        try {
            $gerenteInput = $request->input('gerente');
        
            // Consultamos si ya existe esta gerente
            $gerente = Gerente::where('gerente', $gerenteInput)->first();

            if ($gerente) {
                return response()->json(['success' => true, 'data' => $gerente]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe gerente']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
