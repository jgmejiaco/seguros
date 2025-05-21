<?php

namespace App\Http\Controllers\productos;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\productos\ProductoIndex;
use App\Http\Responsable\productos\ProductoStore;
use App\Http\Responsable\productos\ProductoUpdate;
use App\Http\Responsable\productos\ProductoEdit;
use App\Models\Producto;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductoIndex();
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
        return new ProductoStore($request);
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
    public function edit(string $idProducto)
    {
        return new ProductoEdit($idProducto);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idProducto)
    {
        return new ProductoUpdate($idProducto);
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

    public function queryCodigoProducto(Request $request)
    {
        try {
            $codigoProducto = $request->input('codigo_producto');
        
            // Consultamos si ya existe este código del producto
            $producto = Producto::where('codigo_producto', $codigoProducto)->first();

            if ($producto) {
                return response()->json(['success' => true, 'data' => $producto]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe ese código de producto']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function consultarProducto(Request $request)
    {
        try {
            $productoInput = $request->input('producto');
        
            // Consultamos si ya existe este producto
            $producto = Producto::where('producto', $productoInput)->first();

            if ($producto) {
                return response()->json(['success' => true, 'data' => $producto]);
            } else {
                return response()->json(['success' => false, 'message' => 'No existe producto']);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }
}
