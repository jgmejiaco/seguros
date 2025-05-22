<?php

namespace App\Http\Controllers\medios_pago;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\medios_pago\MedioPagoIndex;
use App\Http\Responsable\medios_pago\MedioPagoStore;
use App\Http\Responsable\medios_pago\MedioPagoUpdate;
use App\Http\Responsable\medios_pago\MedioPagoEdit;
use App\Models\MedioPago;

class MediosPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new MedioPagoIndex();
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
        return new MedioPagoStore($request);
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
    public function edit(string $idMedioPago)
    {
        return new MedioPagoEdit($idMedioPago);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idMedioPago)
    {
        return new MedioPagoUpdate($idMedioPago);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idMedioPago)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    public function consultarMedioPago(Request $request)
    {
        try {
            $medioPagoInput = $request->input('medio_pago');
        
            // Consultamos si ya existe este MedioPago
            $medioPago = MedioPago::where('medio_pago', $medioPagoInput)->first();

            if ($medioPago) {
                return response()->json(['success' => true, 'data' => $medioPago]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe Medio de Pago']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
