<?php

namespace App\Http\Controllers\aseguradoras;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\aseguradoras\AseguradoraIndex;
use App\Http\Responsable\aseguradoras\AseguradoraStore;
use App\Http\Responsable\aseguradoras\AseguradoraUpdate;
use App\Http\Responsable\aseguradoras\AseguradoraEdit;
use App\Models\Aseguradora;

class AseguradorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AseguradoraIndex();
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
        return new AseguradoraStore($request);
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
    public function edit(string $idAseguradora)
    {
        return new AseguradoraEdit($idAseguradora);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idAseguradora)
    {
        return new AseguradoraUpdate($idAseguradora);
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

    public function consultarAseguradora(Request $request)
    {
        try {
            $aseguradoraInput = $request->input('aseguradora');
        
            // Consultamos si ya existe esta aseguradora
            $aseguradora = Aseguradora::where('aseguradora', $aseguradoraInput)->first();

            if ($aseguradora) {
                return response()->json(['success' => true, 'data' => $aseguradora]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe aseguradora']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
    
    // ======================================================================
    // ======================================================================

    public function consultarNitAseguradora(Request $request)
    {
        try {
            $nitAseguradoraInput = $request->input('nit_aseguradora');
        
            // Consultamos si ya existe esta aseguradora
            $aseguradora = Aseguradora::where('nit_aseguradora', $nitAseguradoraInput)->first();

            if ($aseguradora) {
                return response()->json(['success' => true, 'data' => $aseguradora]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe aseguradora']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
