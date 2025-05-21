<?php

namespace App\Http\Controllers\estados;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\estados\EstadoIndex;
use App\Http\Responsable\estados\EstadoStore;
use App\Http\Responsable\estados\EstadoUpdate;
use App\Http\Responsable\estados\EstadoEdit;
use App\Models\Estado;

class EstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new EstadoIndex();
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
        return new EstadoStore($request);
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
    public function edit(string $idEstado)
    {
        return new EstadoEdit($idEstado);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idEstado)
    {
        return new EstadoUpdate($idEstado);
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

    public function consultarEstado(Request $request)
    {
        try {
            $estadoInput = $request->input('estado');
        
            // Consultamos si ya existe este estado
            $estado = Estado::where('estado', $estadoInput)->first();

            if ($estado) {
                return response()->json(['success' => true, 'data' => $estado]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe estado']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
