<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class RamosHelper
{
    protected static $ramos = [
        ['id_ramo' => 1, 'ramo' => 'Accidentes Personales', 'id_estado' => 1],
        ['id_ramo' => 2, 'ramo' => 'Asistencia en Viajes', 'id_estado' => 1],
        ['id_ramo' => 3, 'ramo' => 'Autos', 'id_estado' => 1],
        ['id_ramo' => 4, 'ramo' => 'Mascota', 'id_estado' => 1],
        ['id_ramo' => 5, 'ramo' => 'Pymes', 'id_estado' => 1],
        ['id_ramo' => 6, 'ramo' => 'Responsabilidad Civíl', 'id_estado' => 1],
        ['id_ramo' => 7, 'ramo' => 'Salud', 'id_estado' => 1],
        ['id_ramo' => 8, 'ramo' => 'Vida Individual', 'id_estado' => 1],
        ['id_ramo' => 10, 'ramo' => 'Autos y Motos Obligatorios', 'id_estado' => 1],
        ['id_ramo' => 11, 'ramo' => 'Cumplimiento', 'id_estado' => 1],
        ['id_ramo' => 12, 'ramo' => 'Educativo', 'id_estado' => 1],
        ['id_ramo' => 13, 'ramo' => 'Enfermedades Graves', 'id_estado' => 1],
        ['id_ramo' => 14, 'ramo' => 'Exequial', 'id_estado' => 1],
        ['id_ramo' => 15, 'ramo' => 'Hogar', 'id_estado' => 1],
        ['id_ramo' => 16, 'ramo' => 'Incendio', 'id_estado' => 1],
        ['id_ramo' => 17, 'ramo' => 'Todo Riesgo Empresarial', 'id_estado' => 1],
        ['id_ramo' => 18, 'ramo' => 'Transportes', 'id_estado' => 1],
        ['id_ramo' => 19, 'ramo' => 'Vida', 'id_estado' => 1],
        ['id_ramo' => 20, 'ramo' => 'Vida Grupo', 'id_estado' => 1],
    ];

    public static function cargarRamos()
    {
        foreach (self::$ramos as $ramo) {
            DB::table('ramos')->updateOrInsert(
                ['id_ramo' => $ramo['id_ramo']],
                ['ramo' => $ramo['ramo'], 'id_estado' => $ramo['id_estado']]
            );
        }
    }
}
