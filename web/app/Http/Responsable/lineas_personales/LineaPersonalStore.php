<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class LineaPersonalStore implements Responsable
{
    use MetodosTrait;
    use FileUploadTrait;
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
        $requiredDate = 'required|date';
        $requiredInteger = 'required|integer';
        $requiredString = 'required|string';

        $validator = Validator::make($request->all(), [
            'fecha_radicado'            => $requiredDate,
            'id_aseguradora'            => $requiredInteger,
            'poliza_asistente'          => $requiredString,
            'identificacion_tomador'    => $requiredString,
            'tomador'                   => $requiredString,
            'id_producto'               => $requiredInteger,
            'prima_anualizada'          => $requiredString,
            'id_frecuencia'             => $requiredInteger,
            'id_proceso'                => $requiredInteger,
            'id_estado_inicial'         => $requiredInteger,
            'id_consultor'              => $requiredInteger,
            'id_estado_poliza'          => $requiredInteger
        ], [
            'fecha_radicado.required'         => 'La fecha de radicado es obligatoria.',
            'fecha_radicado.date'             => 'La fecha de radicado no tiene un formato válido.',

            'id_aseguradora.required'         => 'Debe seleccionar una aseguradora.',
            'id_aseguradora.integer'          => 'El campo aseguradora debe ser un número.',

            'poliza_asistente.required'       => 'Debe ingresar el número de póliza.',
            'identificacion_tomador.required' => 'Debe ingresar la identificación del tomador.',
            'tomador.required'                => 'Debe ingresar el nombre del tomador.',

            'id_producto.required'            => 'Debe seleccionar un producto.',
            'id_producto.integer'             => 'El campo producto debe ser un número.',

            'prima_anualizada.required'       => 'Debe ingresar la prima anualizada.',

            'id_frecuencia.required'          => 'Debe seleccionar una frecuencia.',
            'id_frecuencia.integer'           => 'El campo frecuencia debe ser un número.',

            'id_proceso.required'             => 'Debe seleccionar un proceso.',
            'id_proceso.integer'              => 'El campo proceso debe ser un número.',

            'id_estado_inicial.required'      => 'Debe seleccionar un estado inicial.',
            'id_estado_inicial.integer'       => 'El campo estado inicial debe ser un número.',

            'id_consultor.required'           => 'Debe seleccionar un consultor.',
            'id_consultor.integer'            => 'El campo consultor debe ser un número.',

            'id_estado_poliza.required'       => 'Debe seleccionar un estado de póliza.',
            'id_estado_poliza.integer'        => 'El campo estado de póliza debe ser un número.'
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Todos los campos son obligatorios excepto los archivos.');
            return back()->withErrors($validator)->withInput();
        }

        // ==============================================================================

        // Si pasa la validación
        $fechaRadicado = $request->input('fecha_radicado');
        $idAseguradora = $request->input('id_aseguradora');
        $polizaAsistente = $request->input('poliza_asistente');
        $identificacionTomador = $request->input('identificacion_tomador');
        $tomador = ucwords(strtolower(trim($request->input('tomador'))));
        $direccionTomador = $request->input('direccion_tomador');
        $celularTomador = $request->input('celular_tomador');
        $correoTomador = $request->input('correo_tomador');
        $fechaNacimiento = $request->input('fecha_nacimiento');
        $idProducto = $request->input('id_producto');
        $primaAnualizada = $request->input('prima_anualizada');
        $idFrecuencia = $request->input('id_frecuencia');
        $idProceso = $request->input('id_proceso');
        $idEstadoInicial = $request->input('id_estado_inicial');
        $fechaEmision = $request->input('fecha_emision');
        $idConsultor = $request->input('id_consultor');
        $consultor = $request->input('consultor');
        $idEstadoPoliza = $request->input('id_estado_poliza');
        $fechaCancelacion = $request->input('fecha_cancelacion');

        $polizaAsistente = ($polizaAsistente === 'N/A') ? 'NA' : $polizaAsistente;

        // ==============================================================================

        $nombreTomador = Str::slug($tomador, '_'); // reemplaza espacios y caracteres especiales por _
        $nombreConsultor = Str::slug($consultor, '_');

        $fileNameCedula = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameMatricula = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameSolicitudAsegurabilidad = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameSarlaft = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameCaratulaPoliza = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameRenovacion = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;
        $fileNameOtros = $fechaRadicado . '_' .$polizaAsistente. '_' . $identificacionTomador . '_'. $nombreTomador . '_'. $nombreConsultor;

        $carpetaArchivos = 'upfiles/lineas_personales';

        // ==============================================================================

        $fileCedula = '';
        if ($request->hasFile('file_cedula')) {
            $fileCedula = $this->upfileWithName($fileNameCedula, $carpetaArchivos, $request, 'file_cedula', 'cedula');
        }

        // ===============================
        
        $fileMatricula = '';
        if ($request->hasFile('file_matricula')) {
            $fileMatricula = $this->upfileWithName($fileNameMatricula, $carpetaArchivos, $request, 'file_matricula', 'matricula');
        }

        // ===============================
        
        $fileSolicitudAsegurabilidad = '';
        if ($request->hasFile('file_asegurabilidad')) {
            $fileSolicitudAsegurabilidad = $this->upfileWithName($fileNameSolicitudAsegurabilidad, $carpetaArchivos, $request, 'file_asegurabilidad', 'asegurabilidad');
        }

        // ===============================
        
        $fileSarlaft = '';
        if ($request->hasFile('file_sarlaft')) {
            $fileSarlaft = $this->upfileWithName($fileNameSarlaft, $carpetaArchivos, $request, 'file_sarlaft', 'sarlaft');
        }

        // ===============================
        
        $fileCaratulaPoliza = '';
        if ($request->hasFile('file_caratula_poliza')) {
            $fileCaratulaPoliza = $this->upfileWithName($fileNameCaratulaPoliza, $carpetaArchivos, $request, 'file_caratula_poliza', 'caratula_poliza');
        }

        // ===============================
        
        $fileRenovacion = '';
        if ($request->hasFile('file_renovacion')) {
            $fileRenovacion = $this->upfileWithName($fileNameRenovacion, $carpetaArchivos, $request, 'file_renovacion', 'renovacion');
        }

        // ===============================
        
        $fileOtros = '';
        if ($request->hasFile('file_otros')) {
            $fileOtros = $this->upfileWithName($fileNameOtros, $carpetaArchivos, $request, 'file_otros', 'otros');
        }

        // ===============================

        $usuLogueado = session('id_usuario');

        // ===============================

        try {
            $peticionLineaPersonalStore = $this->clientApi->post($this->baseUri.'linea_personal_store', [
                'json' => [
                    'fecha_radicado' => $fechaRadicado,
                    'id_aseguradora' => $idAseguradora,
                    'poliza_asistente' => $polizaAsistente,
                    'identificacion_tomador' => $identificacionTomador,
                    'tomador' =>  $tomador,
                    'direccion_tomador' =>  $direccionTomador,
                    'celular_tomador' =>  $celularTomador,
                    'correo_tomador' =>  $correoTomador,
                    'fecha_nacimiento' =>  $fechaNacimiento,
                    'id_producto' => $idProducto,
                    'prima_anualizada' => $primaAnualizada,
                    'id_frecuencia' => $idFrecuencia,
                    'id_proceso' => $idProceso,
                    'id_estado_inicial' => $idEstadoInicial,
                    'fecha_emision' => $fechaEmision,
                    'id_consultor' => $idConsultor,
                    'id_estado_poliza' => $idEstadoPoliza,
                    'fecha_cancelacion' => $fechaCancelacion,
                    'file_cedula' => $fileCedula,
                    'file_matricula' => $fileMatricula,
                    'file_asegurabilidad' => $fileSolicitudAsegurabilidad,
                    'file_sarlaft' => $fileSarlaft,
                    'file_caratula_poliza' => $fileCaratulaPoliza,
                    'file_renovacion' => $fileRenovacion,
                    'file_otros' => $fileOtros,
                    'id_usuario' => $usuLogueado,
                    'id_audit' => session('id_usuario')
                ]
            ]);

            $resLineaPersonalStore = json_decode($peticionLineaPersonalStore->getBody()->getContents());
            
            if(isset($resLineaPersonalStore) && $resLineaPersonalStore) {

                alert()->success('Éxito', 'Radicado creado exitosamente!');
                return redirect()->route('lineas_personales.index');
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Creando el Radicado, contacte a Soporte.');
            return back();
        }
    }
}
