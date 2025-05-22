<?php

namespace App\Helpers;

use App\Models\Estado;

class EstadosHelper
{
    protected static $estados = [
        'Activo',
        'Inactivo',
        'Anuladas',
        'Aprobada',
        'Bloqueo',
        'Cambio de Asesor Realizado',
        'Cancelada',
        'Dada de Baja',
        'Declinada',
        'Declinada/Rechazada',
        'Desiste',
        'Devolución',
        'Emitida',
        'Firma Electrónica Realizada',
        'Inspección Realizada',
        'No Asegurable',
        'No renovada',
        'Pte Firma Electrónica',
        'Pte Inspección',
        'Pte Sura',
        'Renovación',
        'Requisito Entregado',
        'Requisito Pendiente',
        'Revigorizada/Rehabilitada',
        'Suscripción',
        'Vigente',
        '#N/D',
    ];

    public static function cargarEstados()
    {
        foreach (self::$estados as $nombreEstado) {
            Estado::firstOrCreate(['estado' => $nombreEstado]);
        }
    }
}
