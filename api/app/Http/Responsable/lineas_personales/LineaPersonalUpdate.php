<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\LineaPersonal;

class LineaPersonalUpdate implements Responsable
{
    protected $idLineasPersonal;

    public function __construct($idLineasPersonal)
    {
        $this->idLineasPersonal = $idLineasPersonal;
    }

    public function toResponse($request)
    {
        $radicado = LineaPersonal::findOrFail($this->idLineasPersonal);

        // =================================================
        
        try {
            if (isset($radicado) && !is_null($radicado) && !empty($radicado)) {
                $radicado->fecha_radicado = $request->input('fecha_radicado');
                $radicado->id_aseguradora = $request->input('id_aseguradora');
                $radicado->poliza_asistente = $request->input('poliza_asistente');
                $radicado->identificacion_tomador = $request->input('identificacion_tomador');
                $radicado->tomador = $request->input('tomador');
                $radicado->direccion_tomador = $request->input('direccion_tomador');
                $radicado->celular_tomador = $request->input('celular_tomador');
                $radicado->correo_tomador = $request->input('correo_tomador');
                $radicado->fecha_nacimiento = $request->input('fecha_nacimiento');
                $radicado->id_producto = $request->input('id_producto');
                $radicado->prima_anualizada = $request->input('prima_anualizada');
                $radicado->id_frecuencia = $request->input('id_frecuencia');
                $radicado->id_proceso = $request->input('id_proceso');
                $radicado->id_estado_inicial = $request->input('id_estado_inicial');
                $radicado->fecha_emision = $request->input('fecha_emision');
                $radicado->id_consultor = $request->input('id_consultor');
                $radicado->id_estado_poliza = $request->input('id_estado_poliza');
                $radicado->fecha_cancelacion = $request->input('fecha_cancelacion');
                $radicado->file_cedula = $request->input('file_cedula');
                $radicado->file_matricula = $request->input('file_matricula');
                $radicado->file_asegurabilidad = $request->input('file_asegurabilidad');
                $radicado->file_sarlaft = $request->input('file_sarlaft');
                $radicado->file_caratula_poliza = $request->input('file_caratula_poliza');
                $radicado->file_renovacion = $request->input('file_renovacion');
                $radicado->file_otros = $request->input('file_otros');
                $radicado->id_usuario = $request->input('id_usuario');
                $radicado->update();

                return response()->json(['success' => true]);
            }
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()]);
        }
        
    }
}
