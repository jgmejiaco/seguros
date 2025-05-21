<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ProductoUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idProducto;

    public function __construct($idProducto)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idProducto = $idProducto;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_producto'   =>  'required|string',
            'producto'          =>  'required|string',
            'id_ramo'         =>  'required|integer',
            'id_estado'         =>  'required|integer',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Ambos campos son obligatorios!');
            return redirect()->route('productos.index');
        }

        // =============================================================

        // Si pasa la validación
        $idProducto = $this->idProducto;
        $codigoProducto = $request->input('codigo_producto');
        $producto = $request->input('producto');
        $idRamo = $request->input('id_ramo');
        $idEstado = $request->input('id_estado');

        // =============================================================

        // Consultamos si ya existe ese código del producto
        $consultarCodigoProducto = $this->consultarCodigoProducto($codigoProducto);

        if(isset($consultarCodigoProducto) && $consultarCodigoProducto->success && isset($consultarCodigoProducto->data) && $consultarCodigoProducto->data->id_producto != $idProducto) {

            alert()->warning('Atención', 'Este código del producto ya existe.');
            return back();
        }

        // =============================================================

        // Consultamos si ya existe esa producto
        $consultarProducto = $this->consultarProducto($producto);

        // =============================================================

        // Si existe la producto
        if (isset($consultarProducto->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarProducto->data->id_producto == $idProducto &&
                $consultarProducto->data->codigo_producto == $codigoProducto &&
                $consultarProducto->data->producto == $producto &&
                $consultarProducto->data->id_estado == $idEstado &&
                $consultarProducto->data->id_ramo == $idRamo
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('productos.index');
            }

            // Caso 2: Se debe actualizar
            if (
                ($consultarProducto->data->id_producto == $idProducto) &&
                (
                    $consultarProducto->data->producto != $producto ||
                    $consultarProducto->data->id_estado != $idEstado ||
                    $consultarProducto->data->codigo_producto != $codigoProducto ||
                    $consultarProducto->data->id_estado != $idRamo
                )
            ) {
                return $this->actualizarProducto($idProducto, $producto, $idEstado, $codigoProducto, $idRamo);
            }
        }

        // Caso 3: Si ya existe otro producto con el mismo nombre
        // if ($consultarProducto && $consultarProducto->success) {
        //     alert()->warning('Atención', 'Este producto ya existe.');
        //     return back();
        // }

        // Si no existe la producto, la actualizamos
        return $this->actualizarProducto($idProducto, $producto, $idEstado, $codigoProducto, $idRamo);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    private function consultarCodigoProducto($codigoProducto)
    {
        try {
            $queryCodigoProducto = $this->clientApi->post($this->baseUri.'query_codigo_producto', [
                'query' => ['codigo_producto' => $codigoProducto]
            ]);
            return json_decode($queryCodigoProducto->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, consultando el código del producto, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
    }

    
    // ===================================================================
    // ===================================================================

    // Método para consultar el producto
    private function consultarProducto($producto)
    {
        try {
            $queryProducto = $this->clientApi->post($this->baseUri.'consultar_producto', [
                'query' => ['producto' => $producto]
            ]);
            return json_decode($queryProducto->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando el nombre del producto, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar el producto
    private function actualizarProducto($idProducto, $producto, $idEstado, $codigoProducto, $idRamo)
    {
        try {
            $peticionProductoUpdate = $this->clientApi->put($this->baseUri . 'producto_update/' . $idProducto, [
                'json' => [
                    'codigo_producto' => strtoupper($codigoProducto),
                    'producto' => ucwords(strtolower(trim($producto))),
                    'id_ramo' => $idRamo,
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resProductoUpdate = json_decode($peticionProductoUpdate->getBody()->getContents());

            if (isset($resProductoUpdate) && $resProductoUpdate->success) {
                alert()->success('Exito', 'Producto editado satisfactoriamente.');
                return redirect()->route('productos.index');
            }

        } catch (Exception $e) {
            alert()->error('Error editando el producto, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
    }
}
