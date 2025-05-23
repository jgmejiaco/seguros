<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FinancieraUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idFinanciera;

    public function __construct($idFinanciera)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idFinanciera = $idFinanciera;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $validator = Validator::make($request->all(), [
            'financiera'    => 'required|string'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Financiera es obligatorio');
            return redirect()->route('financieras.index');
        }

        // Si pasa la validación
        $idFinanciera = $this->idFinanciera;
        $financiera = $request->input('financiera');

        // Consultamos si ya existe ese estado
        $consultarFinanciera = $this->consultarFinanciera($financiera);


        // Si existe la aseguradora
        if (isset($consultarFinanciera->data)) {

            // Caso 1: No hay cambios
            if ($consultarFinanciera->data->id_financiera == $idFinanciera && $consultarFinanciera->data->financiera == $financiera) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('financieras.index');
            }

            // Caso 2: Se debe actualizar (solo estado cambia)
            if ($consultarFinanciera->data->id_financiera == $idFinanciera && $consultarFinanciera->data->financiera != $financiera) {
                return $this->actualizarFinanciera($idFinanciera, $financiera);
            }
        }

        // Caso 3: Si ya existe otra aseguradora con el mismo nombre
        if ($consultarFinanciera && $consultarFinanciera->success) {
            alert()->warning('Precaución', 'Esta Financiera ya existe.');
            return back();
        }

        // Si no existe el estado, la actualizamos
        return $this->actualizarFinanciera($idFinanciera, $financiera);

    } // FIN toResponse($request)
    
    // ===================================================================
    // ===================================================================

    // Método para consultar el estado
    private function consultarFinanciera($financiera)
    {
        try {
            $queryFinanciera = $this->clientApi->post($this->baseUri.'consultar_financiera', [
                'query' => ['financiera' => $financiera]
            ]);
            return json_decode($queryFinanciera->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando la Financiera, contacte a Soporte.');
            return redirect()->route('financieras.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar el estado
    private function actualizarFinanciera($idFinanciera, $financiera)
    {
        try {
            $peticionFinancieraUpdate = $this->clientApi->put($this->baseUri . 'financiera_update/' . $idFinanciera, [
                'json' => [
                    'financiera' => ucwords(strtolower(trim($financiera))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resFinancieraUpdate = json_decode($peticionFinancieraUpdate->getBody()->getContents());

            if (isset($resFinancieraUpdate->success) && $resFinancieraUpdate->success) {
                alert()->success('Exito', 'Financiera editada satisfactoriamente.');
                return redirect()->route('financieras.index');
            }
        } catch (Exception $e) {
            alert()->error('Error actualizando la Financiera, contacte a Soporte.');
            return redirect()->route('financieras.index');
        }
    }
}
