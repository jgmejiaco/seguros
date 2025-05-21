<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\LineaPersonal;

class LineaPersonalStore implements Responsable
{
    public function toResponse($request)
    {
        $fechaRadicado = $request->input('fecha_radicado');
        $idAseguradora = $request->input('id_aseguradora');
        $polizaAsistente = $request->input('poliza_asistente');
        $identificacionTomador = $request->input('identificacion_tomador');
        $tomador = $request->input('tomador');
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
        $idEstadoPoliza = $request->input('id_estado_poliza');
        $fechaCancelacion = $request->input('fecha_cancelacion');

        $fileCedula = $request->input('file_cedula');
        $fileMatricula = $request->input('file_matricula');
        $fileSolicitudAsegurabilidad = $request->input('file_asegurabilidad');
        $fileSarlaft = $request->input('file_sarlaft');
        $fileCaratulaPoliza = $request->input('file_caratula_poliza');
        $fileRenovacion = $request->input('file_renovacion');
        $fileOtros = $request->input('file_otros');

        $usuLogueado = $request->input('id_usuario');

        // =================================================

        try {
            $nuevoRadicado = LineaPersonal::create([
                'fecha_radicado' => $fechaRadicado,
                'id_aseguradora' => $idAseguradora,
                'poliza_asistente' => $polizaAsistente,
                'identificacion_tomador' => $identificacionTomador,
                'tomador' => $tomador,
                'direccion_tomador' => $direccionTomador,
                'celular_tomador' => $celularTomador,
                'correo_tomador' => $correoTomador,
                'fecha_nacimiento' => $fechaNacimiento,
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
                'id_usuario' => $usuLogueado
            ]);
    
            if ($nuevoRadicado) {
                return response()->json(true);
            }

        } catch (Exception $e) {
            return response()->json(['error_bd'=>$e->getMessage()]);
        }
    }
}
