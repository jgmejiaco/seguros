<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Producto;

class ProductoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $productos = Producto::leftJoin('estados', 'estados.id_estado', '=', 'productos.id_estado')
                ->leftJoin('ramos', 'ramos.id_ramo', '=', 'productos.id_ramo')
                ->select(
                    'id_producto',
                    'codigo_producto',
                    'producto',
                    'ramos.id_ramo',
                    'ramos.ramo',
                    'estados.id_estado',
                    'estados.estado',
                )
                ->orderBy('producto','asc')
                ->get();

            return response()->json($productos);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
