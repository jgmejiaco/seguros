<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class GerenteStore implements Responsable
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
            'gerente' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Gerencia es obligatoria');
            return redirect()->route('gerentes.index');
        }

        // Si pasa la validación
        $gerente = $request->input('gerente');
        $idEstado = 1;

        // Consultamos si ya existe esa aseguradora
        $consultarGerente = $this->consultarGerente($gerente);
        
        if($consultarGerente && $consultarGerente->success) {
            alert()->info('Info', 'Este gerente ya existe.');
            return back();
        }

        try {
            $peticionGerenteStore = $this->clientApi->post($this->baseUri . 'gerente_store', [
                'json' => [
                    'gerente' => ucwords(strtolower(trim($gerente))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resGerenteStore = json_decode($peticionGerenteStore->getBody()->getContents());
            
            if (isset($resGerenteStore->success) && $resGerenteStore->success === true) {
                alert()->success('Éxito', 'Gerente creado satisfactoriamente');
                return redirect()->route('gerentes.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('gerentes.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarGerente($gerente)
    {
        try {
            $queryGerente = $this->clientApi->post($this->baseUri.'consultar_gerente', [
                'query' => ['gerente' => $gerente]
            ]);
            return json_decode($queryGerente->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, contacte a Soporte.');
            return redirect()->route('gerentes.index');
        }
    }
}
