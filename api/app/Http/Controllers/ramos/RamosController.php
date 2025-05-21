<?php

namespace App\Http\Controllers\ramos;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\ramos\RamoIndex;
use App\Http\Responsable\ramos\RamoStore;
use App\Http\Responsable\ramos\RamoUpdate;
use App\Http\Responsable\ramos\RamoEdit;
use App\Models\Ramo;

class RamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RamoIndex();
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
        return new RamoStore($request);
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
    public function edit(string $idRamo)
    {
        return new RamoEdit($idRamo);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idRamo)
    {
        return new RamoUpdate($idRamo);
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

    public function consultarRamo(Request $request)
    {
        try {
            $ramoInput = $request->input('ramo');
        
            // Consultamos si ya existe esta ramo
            $ramo = Ramo::where('ramo', $ramoInput)->first();

            if ($ramo) {
                return response()->json(['success' => true, 'data' => $ramo]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe Ramo']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
