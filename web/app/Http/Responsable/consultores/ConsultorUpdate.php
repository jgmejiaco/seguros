<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ConsultorUpdate implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idConsultor;

    public function __construct($idConsultor)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idConsultor = $idConsultor;
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
            'id_estado'              => 'required|integer'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Ambos campos son obligatorios!');
            return redirect()->route('consultores.index');
        }

        // =============================================================

        // Si pasa la validación
        $idConsultor = $this->idConsultor;
        $claveConsultorGlobal = $request->input('clave_consultor_global');
        $consultor = $request->input('consultor');
        $gerenteComercial = $request->input('gerente_comercial');
        $liderComercial = $request->input('lider_comercial');
        $equipoInformes = $request->input('equipo_informes');
        $idEstado = $request->input('id_estado');
        
        // =============================================================

        // Consultamos si ya existe esa clave consultor global
        $consultarClaveConsultorGlobal = $this->consultarClaveConsultorGlobal($claveConsultorGlobal);

        if(isset($consultarClaveConsultorGlobal) && $consultarClaveConsultorGlobal->success && $consultarClaveConsultorGlobal->data && $consultarClaveConsultorGlobal->data->id_consultor != $idConsultor) {

            // if ( isset($consultarClaveConsultorGlobal->data) && $consultarClaveConsultorGlobal->data->id_consultor != $idConsultor ) {
            alert()->warning('Atención', 'Esta clave del consultor Global ya existe.');
            return back();
        // }
        }

        // =============================================================

        // Consultamos si ya existe esa consultor
        $consultarConsultor = $this->consultarConsultor($consultor);

        // Si existe la consultor
        if (isset($consultarConsultor->data)) {

            // Caso 1: No hay cambios
            if (
                $consultarConsultor->data->id_consultor == $idConsultor &&
                $consultarConsultor->data->clave_consultor_global == $claveConsultorGlobal &&
                $consultarConsultor->data->consultor == $consultor &&
                $consultarConsultor->data->gerente_comercial == $gerenteComercial &&
                $consultarConsultor->data->lider_comercial == $liderComercial &&
                $consultarConsultor->data->equipo_informes == $equipoInformes &&
                $consultarConsultor->data->id_estado == $idEstado
            ) {
                alert()->info('Info', 'No hay cambios a realizar!');
                return redirect()->route('consultores.index');
            }

            // Caso 2: Se debe actualizar (solo id_estado cambia)
            if (
                ($consultarConsultor->data->id_consultor == $idConsultor) && (
                    $consultarConsultor->data->clave_consultor_global != $claveConsultorGlobal ||
                    $consultarConsultor->data->consultor != $consultor ||
                    $consultarConsultor->data->gerente_comercial != $gerenteComercial ||
                    $consultarConsultor->data->lider_comercial != $liderComercial ||
                    $consultarConsultor->data->equipo_informes != $equipoInformes ||
                    $consultarConsultor->data->id_estado != $idEstado
                )
            ) {
                return $this->actualizarConsultor($idConsultor, $consultor, $idEstado, $claveConsultorGlobal,$gerenteComercial,$liderComercial,$equipoInformes);
            }
        }

        // Caso 3: Si ya existe otra consultor con el mismo nombre
        if ($consultarConsultor && $consultarConsultor->success) {
            alert()->warning('Atención', 'Este consultor ya existe.');
            return back();
        }

        // Si no existe la consultor, la actualizamos
        return $this->actualizarConsultor($idConsultor, $consultor, $idEstado, $claveConsultorGlobal,$gerenteComercial,$liderComercial,$equipoInformes);

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

    // Método para consultar la consultor
    private function consultarConsultor($consultor)
    {
        try {
            $queryConsultor = $this->clientApi->post($this->baseUri.'consultar_consultor', [
                'query' => ['consultor' => $consultor]
            ]);
            return json_decode($queryConsultor->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error consultando el nombre del consultor, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    }

    // ===================================================================
    // ===================================================================

    // Método para actualizar la consultor
    private function actualizarConsultor($idConsultor, $consultor, $idEstado, $claveConsultorGlobal,$gerenteComercial,$liderComercial,$equipoInformes)
    {
        try {
            $peticionConsultorUpdate = $this->clientApi->put($this->baseUri . 'consultor_update/' . $idConsultor, [
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
            $resConsultorUpdate = json_decode($peticionConsultorUpdate->getBody()->getContents());

            if (isset($resConsultorUpdate) && $resConsultorUpdate->success) {
                alert()->success('Exito', 'Consultor editado satisfactoriamente.');
                return redirect()->route('consultores.index');
            }

        } catch (Exception $e) {
            alert()->error('Error editando el consultor, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    }
}
