<?php

namespace App\Http\Responsable\gerentes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class GerenteUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idGerente;

    public function __construct($idGerente)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idGerente = $idGerente;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'gerente'           => 'required|string',
            'id_estado'         => 'required|integer'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Gerente es obligatoria');
            return redirect()->route('gerentes.index');
        }

        // Si pasa la validación
        $idGerente = $this->idGerente;
        $gerente = $request->input('gerente');
        $idEstado = $request->input('id_estado');

        // Consultamos si ya existe ese gerente
        $consultarGerente = $this->consultarGerente($gerente);


        // Si existe la aseguradora
        if (isset($consultarGerente->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarGerente->data->id_gerente == $idGerente &&
                $consultarGerente->data->gerente == $gerente &&
                $consultarGerente->data->id_estado == $idEstado
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('gerentes.index');
            }

            // Caso 2: Se debe actualizar (solo id_estado cambia)
            if (
                ($consultarGerente->data->id_gerente == $idGerente) &&
                ($consultarGerente->data->gerente != $gerente ||
                $consultarGerente->data->id_estado != $idEstado)
            ) {
                return $this->actualizarGerente($idGerente, $gerente, $idEstado);
            }
        }

        // Caso 3: Si ya existe otra aseguradora con el mismo nombre
        if ($consultarGerente && $consultarGerente->success) {
            alert()->warning('Precaución', 'Este gerente ya existe.');
            return back();
        }

        // Si no existe la gerente, la actualizamos
        return $this->actualizarGerente($idGerente, $gerente, $idEstado);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar la aseguradora
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

    // ===================================================================
    // ===================================================================

    // Método para actualizar la aseguradora
    private function actualizarGerente($idGerente, $gerente, $idEstado)
    {
        try {
            $peticionGerenteUpdate = $this->clientApi->put($this->baseUri . 'gerente_update/' . $idGerente, [
                'json' => [
                    'gerente' => ucwords(strtolower(trim($gerente))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resGerenteUpdate = json_decode($peticionGerenteUpdate->getBody()->getContents());

            if (isset($resGerenteUpdate->success) && $resGerenteUpdate->success) {
                alert()->success('Exito', 'Gerente editado satisfactoriamente.');
                return redirect()->route('gerentes.index');
            }
        } catch (Exception $e) {
            alert()->error('Error editando el gerente, contacte a Soporte.');
            return redirect()->route('gerentes.index');
        }
    }
}
