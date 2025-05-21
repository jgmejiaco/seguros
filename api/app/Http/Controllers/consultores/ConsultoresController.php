<?php

namespace App\Http\Controllers\consultores;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\consultores\ConsultorIndex;
use App\Http\Responsable\consultores\ConsultorStore;
use App\Http\Responsable\consultores\ConsultorUpdate;
use App\Http\Responsable\consultores\ConsultorEdit;
use App\Models\Consultor;

class ConsultoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ConsultorIndex();
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
        return new ConsultorStore($request);
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
    public function edit(Request $request, string $idConsultor)
    {
        return new ConsultorEdit($idConsultor);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idConsultor)
    {
        return new ConsultorUpdate($idConsultor);
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

    public function queryClaveConsultorGlobal(Request $request)
    {
        try {
            $claveConsultorGlobal = $request->input('clave_consultor_global');
        
            // Consultamos si ya existe esta aseguradora
            $consultor = Consultor::where('clave_consultor_global', $claveConsultorGlobal)->first();

            if ($consultor) {
                return response()->json(['success' => true, 'data' => $consultor]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe consultor']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function consultarConsultor(Request $request)
    {
        try {
            $consultorInput = $request->input('consultor');
        
            // Consultamos si ya existe esta aseguradora
            $consultor = Consultor::where('consultor', $consultorInput)->first();

            if ($consultor) {
                return response()->json(['success' => true, 'data' => $consultor]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe consultor']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
