<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class EstadoStore implements Responsable
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
            'estado' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'El Estado es obligatorio');
            return redirect()->route('estados.index');
        }

        // Si pasa la validación
        $estado = $request->input('estado');

        // Consultamos si ya existe esa aseguradora
        $consultarEstado = $this->consultarEstado($estado);
        
        if($consultarEstado && $consultarEstado->success) {
            alert()->info('Info', 'Este Estado ya existe.');
            return back();
        }

        try {
            $peticionEstadoStore = $this->clientApi->post($this->baseUri . 'estado_store', [
                'json' => [
                    'estado' => ucwords(strtolower(trim($estado))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resEstadoStore = json_decode($peticionEstadoStore->getBody()->getContents());
            
            if (isset($resEstadoStore->success) && $resEstadoStore->success === true) {
                alert()->success('Éxito', 'Estado creado satisfactoriamente');
                return redirect()->route('estados.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('estados.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarEstado($estado)
    {
        try {
            $queryEstado = $this->clientApi->post($this->baseUri.'consultar_estado', [
                'query' => ['estado' => $estado]
            ]);
            return json_decode($queryEstado->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('estados.index');
        }
    }
}
