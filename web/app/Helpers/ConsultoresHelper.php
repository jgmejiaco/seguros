<?php

namespace App\Helpers;

use App\Models\Consultor;

class ConsultoresHelper
{
    protected static $equipos = [
        'Alternativos',
        'Cartera Huerfana',
        'Impacting Teamn',
        'Mentoria',
        'NA',
        'Promotores',
        'Servicio',
    ];

    protected static $nombresGenerados = [];

    public static function generarConsultores($cantidad = 1000)
    {
        $insertados = 0;

        while ($insertados < $cantidad) {
            $clave = self::generarClaveUnica();
            $consultor = self::nombreUnico();

            // Validar unicidad de clave y consultor
            if (
                Consultor::where('clave_consultor_global', $clave)->exists() ||
                Consultor::where('consultor', $consultor)->exists()
            ) {
                continue;
            }

            $gerente = self::nombreAleatorio();
            $equipo = self::$equipos[array_rand(self::$equipos)];

            Consultor::create([
                'clave_consultor_global' => $clave,
                'consultor' => $consultor,
                'gerente_comercial' => $gerente,
                'lider_comercial' => $gerente, // mismo valor que gerente
                'equipo_informes' => $equipo,
                'id_estado' => 1, // estado fijo
            ]);

            $insertados++;
        }
    }

    protected static function generarClaveUnica()
    {
        return rand(100000, 999999); // 6 dígitos aleatorios
    }

    protected static function nombreAleatorio()
    {
        $nombres = ['Carlos', 'Ana', 'Luis', 'Marta', 'Pedro', 'Laura', 'Andrés', 'Sandra', 'Juan', 'Patricia'];
        $apellidos = ['Gómez', 'Pérez', 'Rodríguez', 'López', 'Martínez', 'Fernández', 'Ramírez', 'Sánchez', 'Torres', 'Hernández'];

        return $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
    }

    protected static function nombreUnico()
    {
        do {
            $nombre = self::nombreAleatorio();
        } while (in_array($nombre, self::$nombresGenerados));

        self::$nombresGenerados[] = $nombre;
        return $nombre;
    }
}
