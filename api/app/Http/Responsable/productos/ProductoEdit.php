<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Producto;

class ProductoEdit implements Responsable
{
    protected $idProducto;

    public function __construct($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function toResponse($request)
    {
        try {
            $producto = Producto::leftJoin('estados', 'estados.id_estado', '=', 'productos.id_estado')
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
                ->where('id_producto',$this->idProducto)
                ->orderBy('producto')
                ->first();

            return response()->json($producto);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
