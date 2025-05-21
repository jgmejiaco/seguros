<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ConsultorStore implements Responsable
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
            'clave_consultor_global' => 'required|string',
            'consultor'              => 'required|string',
            'gerente_comercial'      => 'required|string',
            'lider_comercial'        => 'required|string',
            'equipo_informes'        => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Ambos campos son obligatorios');
            return redirect()->route('consultores.index');
        }

        // =============================================================

        // Si pasa la validación
        $claveConsultorGlobal = $request->input('clave_consultor_global');
        $consultor = $request->input('consultor');
        $gerenteComercial = $request->input('gerente_comercial');
        $liderComercial = $request->input('lider_comercial');
        $equipoInformes = $request->input('equipo_informes');
        $idEstado = 1;

        // Consultamos si ya existe esa clave consultor global
        $consultarClaveConsultorGlobal = $this->consultarClaveConsultorGlobal($claveConsultorGlobal);

        if(isset($consultarClaveConsultorGlobal) && $consultarClaveConsultorGlobal->success) {
            alert()->info('Info', 'Esta clave del consultor ya existe.');
            return back();
        }

        // =============================================================

        // Consultamos si ya existe esa consultor$consultor
        $consultarConsultor = $this->consultarConsultor($consultor);
        
        if($consultarConsultor && $consultarConsultor->success) {
            alert()->info('Info', 'Este nombre de consultor ya existe.');
            return back();
        }

        try {
            $peticionConsultorStore = $this->clientApi->post($this->baseUri . 'consultor_store', [
                'json' => [
                    'clave_consultor_global' => $claveConsultorGlobal,
                    'consultor' => ucwords(strtolower(trim($consultor))),
                    'gerente_comercial' => ucwords(strtolower(trim($gerenteComercial))),
                    'lider_comercial' => ucwords(strtolower(trim($liderComercial))),
                    'equipo_informes' => ucwords(strtolower(trim($equipoInformes))),
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resConsultorStore = json_decode($peticionConsultorStore->getBody()->getContents());
            
            if (isset($resConsultorStore->success) && $resConsultorStore->success === true) {
                alert()->success('Éxito', 'Consultor creado satisfactoriamente');
                return redirect()->route('consultores.index');
            }
        } catch (Exception $e) {
            alert()->error('Error, Exception, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    } // FIN toResponse($request)

    // ===================================================================
    // ===================================================================

    private function consultarClaveConsultorGlobal($claveConsultorGlobal)
    {
        try {
            $peticionClaveConsultorGlobal = $this->clientApi->post($this->baseUri.'query_clave_consultor_global', [
                'json' => ['clave_consultor_global' => $claveConsultorGlobal]
            ]);
            return json_decode($peticionClaveConsultorGlobal->getBody()->getContents());
            
        } catch (Exception $e) {
            alert()->error('Error consultando la clave del Consultor, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    }
    
    // ===================================================================
    // ===================================================================

    private function consultarConsultor($consultor)
    {
        try {
            $queryConsultor = $this->clientApi->post($this->baseUri.'consultar_consultor', [
                'query' => ['consultor' => $consultor]
            ]);
            return json_decode($queryConsultor->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando el nombre del Consultor, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    }
}
