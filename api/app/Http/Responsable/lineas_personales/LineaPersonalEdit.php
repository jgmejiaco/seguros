<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Models\LineaPersonal;

class LineaPersonalEdit implements Responsable
{
    protected $idLineasPersonal;

    public function __construct($idLineasPersonal)
    {
        $this->idLineasPersonal = $idLineasPersonal;
    }

    public function toResponse($request)
    {
        try {
            $radicadoLineaPersonal = LineaPersonal::leftjoin('aseguradoras', 'aseguradoras.id_aseguradora', '=', 'lineas_personales.id_aseguradora')
                ->leftjoin('productos', 'productos.id_producto', '=', 'lineas_personales.id_producto')
                ->leftjoin('ramos', 'ramos.id_ramo', '=', 'productos.id_ramo')
                ->leftjoin('frecuencias', 'frecuencias.id_frecuencia', '=', 'lineas_personales.id_frecuencia')
                ->leftjoin('estados as procesos', 'procesos.id_estado', '=', 'lineas_personales.id_proceso')
                ->leftjoin('estados as estado_inicial', 'estado_inicial.id_estado', '=', 'lineas_personales.id_estado_inicial')
                ->leftjoin('consultores', 'consultores.id_consultor', '=', 'lineas_personales.id_consultor')
                ->leftjoin('estados as estado_poliza', 'estado_poliza.id_estado', '=', 'lineas_personales.id_estado_poliza')
                ->leftjoin('usuarios', 'usuarios.id_usuario', '=', 'lineas_personales.id_usuario')
                ->leftjoin('medios_pago', 'medios_pago.id_medio_pago', '=', 'lineas_personales.id_medio_pago')
                ->leftjoin('financieras', 'financieras.id_financiera', '=', 'lineas_personales.id_financiera')
                ->select(
                    'id_lineas_personal',
                    'fecha_radicado',
                    'aseguradoras.id_aseguradora',
                    'aseguradoras.aseguradora',
                    'poliza_asistente',
                    'identificacion_tomador',
                    'tomador',
                    'ciudad',
                    'direccion_tomador',
                    'celular_tomador',
                    'correo_tomador',
                    'fecha_nacimiento',
                    'productos.id_producto',
                    'productos.producto',
                    'ramos.id_ramo',
                    'ramos.ramo',
                    'prima_anualizada',
                    'frecuencias.id_frecuencia',
                    'frecuencias.frecuencia',
                    'lineas_personales.id_proceso',
                    'procesos.estado as proceso',
                    'lineas_personales.id_estado_inicial',
                    'estado_inicial.estado as estado_inicial',
                    'fecha_emision',
                    'consultores.id_consultor',
                    'consultores.clave_consultor_global',
                    'consultores.consultor',
                    'consultores.gerente_comercial',
                    'consultores.lider_comercial',
                    'consultores.equipo_informes',
                    'lineas_personales.id_estado_poliza',
                    'estado_poliza.estado as estado_poliza',
                    'fecha_cancelacion',
                    'medios_pago.id_medio_pago',
                    'medios_pago.medio_pago',
                    'financieras.id_financiera',
                    'financieras.financiera',
                    'file_cedula',
                    'file_matricula',
                    'file_asegurabilidad',
                    'file_sarlaft',
                    'file_caratula_poliza',
                    'file_renovacion',
                    'file_otros',
                    'usuarios.id_usuario',
                )
                ->where('id_lineas_personal', $this->idLineasPersonal)
                ->orderByDesc('fecha_radicado')
                ->first();

            return response()->json($radicadoLineaPersonal);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()]);
        }
    }
}
