<?php

namespace App\Http\Controllers\financieras;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\financieras\FinancieraIndex;
use App\Http\Responsable\financieras\FinancieraStore;
use App\Http\Responsable\financieras\FinancieraUpdate;
use App\Http\Responsable\financieras\FinancieraEdit;
use App\Models\Financiera;

class FinancierasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new FinancieraIndex();
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
        return new FinancieraStore($request);
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
    public function edit(string $idFinanciera)
    {
        return new FinancieraEdit($idFinanciera);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idFinanciera)
    {
        return new FinancieraUpdate($idFinanciera);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idFinanciera)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    public function consultarFinanciera(Request $request)
    {
        try {
            $financieraInput = $request->input('financiera');
        
            // Consultamos si ya existe este MedioPago
            $financiera = Financiera::where('financiera', $financieraInput)->first();

            if ($financiera) {
                return response()->json(['success' => true, 'data' => $financiera]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe Financiera']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
