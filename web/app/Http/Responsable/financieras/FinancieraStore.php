<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FinancieraStore implements Responsable
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
            'financiera' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'La Financiera es obligatorio');
            return redirect()->route('financieras.index');
        }

        // Si pasa la validación
        $financiera = $request->input('financiera');

        // Consultamos si ya existe esa aseguradora
        $consultarFinanciera = $this->consultarFinanciera($financiera);
        
        if($consultarFinanciera && $consultarFinanciera->success) {
            alert()->info('Info', 'Esta Financiera ya existe.');
            return back();
        }

        try {
            $peticionFinancieraStore = $this->clientApi->post($this->baseUri . 'financiera_store', [
                'json' => [
                    'financiera' => ucwords(strtolower(trim($financiera))),
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resFinancieraStore = json_decode($peticionFinancieraStore->getBody()->getContents());
            
            if (isset($resFinancieraStore->success) && $resFinancieraStore->success === true) {
                alert()->success('Éxito', 'Financiera creada satisfactoriamente');
                return redirect()->route('financieras.index');
            }
        } catch (Exception $e) {
            alert()->error('Error creando la Financiera, contacte a Soporte.');
            return redirect()->route('financieras.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarFinanciera($financiera)
    {
        try {
            $queryFinanciera = $this->clientApi->post($this->baseUri.'consultar_financiera', [
                'query' => ['financiera' => $financiera]
            ]);
            return json_decode($queryFinanciera->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error, consultando la Financiera, contacte a Soporte.');
            return redirect()->route('financieras.index');
        }
    }
}
