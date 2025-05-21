<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class ProductoStore implements Responsable
{
    public function toResponse($request)
    {
        $codigoProducto = $request->input('codigo_producto');
        $producto = $request->input('producto');
        $idRamo = $request->input('id_ramo');
        $idEstado = $request->input('id_estado');

        // =================================================

        try {
            $nuevoProducto = Producto::create([
                'codigo_producto' => $codigoProducto,
                'producto' => $producto,
                'id_estado' => $idEstado,
                'id_ramo' => $idRamo
            ]);
    
            if ($nuevoProducto) {
                return response()->json(['success' => true]);
            }

        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
