<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ProductoStore implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_producto' => 'required|string',
            'producto'        => 'required|string',
            'id_ramo'         => 'required|integer',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Ambos campos son obligatorios');
            return redirect()->route('productos.index');
        }

        // =============================================================

        // Si pasa la validación
        $codigoProducto = $request->input('codigo_producto');
        $producto = $request->input('producto');
        $idRamo = $request->input('id_ramo');
        $idEstado = 1;

        // =============================================================

        // Consultamos si ya existe ese código del producto
        $consultarCodigoProducto = $this->consultarCodigoProducto($codigoProducto);

        if(isset($consultarCodigoProducto->success) && $consultarCodigoProducto->success) {
            alert()->warning('Atención', 'Este código de producto ya existe.');
            return back();
        }

        // =============================================================

        // Consultamos si ya existe ese producto
        // $consultarProducto = $this->consultarProducto($producto);
        
        // if(isset($consultarProducto->success) && $consultarProducto->success) {
        //     alert()->warning('Atención', 'Este nombre de producto ya existe.');
        //     return back();
        // }

        // =============================================================

        try {
            $peticionProductoStore = $this->clientApi->post($this->baseUri . 'producto_store', [
                'json' => [
                    'codigo_producto' => strtoupper($codigoProducto),
                    'producto' => ucwords(strtolower(trim($producto))),
                    'id_ramo' => $idRamo,
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resProductoStore = json_decode($peticionProductoStore->getBody()->getContents());
            
            if (isset($resProductoStore->success) && $resProductoStore->success === true) {
                alert()->success('Éxito', 'Producto creado satisfactoriamente');
                return redirect()->route('productos.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, Creando el producto, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
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

    // private function consultarProducto($producto)
    // {
    //     try {
    //         $queryProducto = $this->clientApi->post($this->baseUri.'consultar_producto', [
    //             'query' => ['producto' => $producto]
    //         ]);
    //         return json_decode($queryProducto->getBody()->getContents());

    //     } catch (Exception $e) {
    //         alert()->error('Error, consultando el nombre del producto, contacte a Soporte.');
    //         return redirect()->route('productos.index');
    //     }
    // }
}
