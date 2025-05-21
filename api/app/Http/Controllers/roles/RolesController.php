<?php

namespace App\Http\Controllers\roles;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\roles\RolIndex;
use App\Http\Responsable\roles\RolStore;
use App\Http\Responsable\roles\RolUpdate;
use App\Http\Responsable\roles\RolEdit;
use App\Models\Rol;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RolIndex();
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
        return new RolStore($request);
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
    public function edit(string $idRol)
    {
        return new RolEdit($idRol);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idRol)
    {
        return new RolUpdate($idRol);
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

    public function consultarRol(Request $request)
    {
        try {
            $rolInput = $request->input('rol');
        
            // Consultamos si ya existe esta ramo
            $rol = Rol::where('name', $rolInput)->first();

            if ($rol) {
                return response()->json(['success' => true, 'data' => $rol]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe Rol']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
