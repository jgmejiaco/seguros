<?php

namespace App\Http\Controllers\lineas_personales;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Responsable\lineas_personales\LineaPersonalIndex;
use App\Http\Responsable\lineas_personales\LineaPersonalStore;
use App\Http\Responsable\lineas_personales\LineaPersonalEdit;
use App\Http\Responsable\lineas_personales\LineaPersonalUpdate;
use App\Http\Responsable\lineas_personales\LineaPersonalDestroy;
use App\Models\Consultor;
use App\Models\Producto;

class LineasPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new LineaPersonalIndex();
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
        return new LineaPersonalStore($request);
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
    public function edit(string $idLineasPersonal)
    {
        return new LineaPersonalEdit($idLineasPersonal);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idLineasPersonal)
    {
        return new LineaPersonalUpdate($idLineasPersonal);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idLineasPersonal)
    {
        return new LineaPersonalDestroy($idLineasPersonal);
    }

    // ======================================================================
    // ======================================================================

    public function queryConsultor($idConsultor)
    {
        try {
            // Consultamos si ya existe este usuario específico
            $consultor = Consultor::where('id_consultor', $idConsultor)->first();

            if ($consultor) {
                return response()->json($consultor);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function queryProducto($idProducto)
    {
        try {
            // Consultamos si ya existe este usuario específico
            $producto = Producto::leftJoin('ramos','ramos.id_ramo','=','productos.id_ramo')
                ->leftJoin('estados','estados.id_estado','=','productos.id_estado')
                ->select(
                    'id_producto',
                    'codigo_producto',
                    'producto',
                    'ramos.id_ramo',
                    'ramo',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->where('id_producto', $idProducto)
                ->first();

            if ($producto) {
                return response()->json($producto);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================
}
