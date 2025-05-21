<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoUpdate implements Responsable
{
    protected $idProducto;

    public function __construct($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function toResponse($request)
    {
        $producto = Producto::findOrFail($this->idProducto);

        // =================================================

        if (isset($producto) && !is_null($producto) && !empty($producto)) {
            try {
                $producto->codigo_producto = $request->input('codigo_producto');
                $producto->producto = $request->input('producto');
                $producto->id_ramo = $request->input('id_ramo');
                $producto->id_estado = $request->input('id_estado');
                $producto->update();

                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error_exception' => $e->getMessage()], 500);
            }
        }
    }
}
