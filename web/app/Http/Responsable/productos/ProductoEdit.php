<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ProductoEdit implements Responsable
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
        try {
            $peticionProductoEdit = $this->clientApi->put($this->baseUri . 'producto_edit/' . $this->idProducto, [
                'json' => []
            ]);
            $resProductoEdit = json_decode($peticionProductoEdit->getBody()->getContents());

            if (isset($resProductoEdit)) {
                return view('productos.modal_editar_producto', compact('resProductoEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error editando el producto, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
    } // FIN toResponse($request)
} // FIN Class ProductoEdit