<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ProductosHelper
{
    protected static $productos = [
        ['id_producto' => 1, 'codigo_producto' => '202', 'producto' => 'Producto 1', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 2, 'codigo_producto' => '201', 'producto' => 'Producto 2', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 4, 'codigo_producto' => '1241', 'producto' => 'Producto 3', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 6, 'codigo_producto' => '40', 'producto' => 'Producto 4', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 7, 'codigo_producto' => '1243', 'producto' => 'Producto 5', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 11, 'codigo_producto' => 'AXA001', 'producto' => 'Producto 6', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 14, 'codigo_producto' => 'OMPEV', 'producto' => 'Producto 7', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 21, 'codigo_producto' => '2005', 'producto' => 'Producto 8', 'id_ramo' => 5, 'id_estado' => 1],
        ['id_producto' => 29, 'codigo_producto' => 'VC2', 'producto' => 'Producto 9', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 31, 'codigo_producto' => 'RCP', 'producto' => 'Producto 10', 'id_ramo' => 6, 'id_estado' => 1],
        ['id_producto' => 35, 'codigo_producto' => '64', 'producto' => 'Producto 11', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 36, 'codigo_producto' => '63', 'producto' => 'Producto 12', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 42, 'codigo_producto' => '623', 'producto' => 'Producto 13', 'id_ramo' => 5, 'id_estado' => 1],
        ['id_producto' => 45, 'codigo_producto' => '177', 'producto' => 'Producto 14', 'id_ramo' => 8, 'id_estado' => 1],
        ['id_producto' => 54, 'codigo_producto' => '022T', 'producto' => 'Producto 15', 'id_ramo' => 1, 'id_estado' => 1],
        ['id_producto' => 55, 'codigo_producto' => '011T', 'producto' => 'Producto 16', 'id_ramo' => 1, 'id_estado' => 1],
        ['id_producto' => 56, 'codigo_producto' => '2013', 'producto' => 'Producto 17', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 57, 'codigo_producto' => '203', 'producto' => 'Producto 18', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 58, 'codigo_producto' => '212', 'producto' => 'Producto 19', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 59, 'codigo_producto' => 'AXA001', 'producto' => 'Producto 20', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 60, 'codigo_producto' => '1242', 'producto' => 'Producto 21', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 61, 'codigo_producto' => 'OMPEV-1', 'producto' => 'Producto 22', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 62, 'codigo_producto' => 'OMPEV', 'producto' => 'Producto 23', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 63, 'codigo_producto' => '196-AMB', 'producto' => 'Producto 24', 'id_ramo' => 12, 'id_estado' => 1],
        ['id_producto' => 64, 'codigo_producto' => '196-COP', 'producto' => 'Producto 25', 'id_ramo' => 12, 'id_estado' => 1],
        ['id_producto' => 65, 'codigo_producto' => '013TT', 'producto' => 'Producto 26', 'id_ramo' => 13, 'id_estado' => 1],
        ['id_producto' => 66, 'codigo_producto' => '981', 'producto' => 'Producto 27', 'id_ramo' => 14, 'id_estado' => 1],
        ['id_producto' => 67, 'codigo_producto' => '2001', 'producto' => 'Producto 28', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 68, 'codigo_producto' => '2012', 'producto' => 'Producto 29', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 69, 'codigo_producto' => '109', 'producto' => 'Producto 30', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 70, 'codigo_producto' => '600', 'producto' => 'Producto 31', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 71, 'codigo_producto' => '28', 'producto' => 'Producto 32', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 72, 'codigo_producto' => '602', 'producto' => 'Producto 33', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 73, 'codigo_producto' => '095-096', 'producto' => 'Producto 34', 'id_ramo' => 13, 'id_estado' => 1],
        ['id_producto' => 74, 'codigo_producto' => 'MAP-MAS', 'producto' => 'Producto 35', 'id_ramo' => 13, 'id_estado' => 1],
        ['id_producto' => 75, 'codigo_producto' => '1371', 'producto' => 'Producto 36', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 76, 'codigo_producto' => 'AXA002', 'producto' => 'Producto 37', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 77, 'codigo_producto' => '134', 'producto' => 'Producto 38', 'id_ramo' => 15, 'id_estado' => 1],
        ['id_producto' => 78, 'codigo_producto' => '777-1', 'producto' => 'Producto 39', 'id_ramo' => 5, 'id_estado' => 1],
        ['id_producto' => 79, 'codigo_producto' => '250', 'producto' => 'Producto 40', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 80, 'codigo_producto' => '113-61', 'producto' => 'Producto 41', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 81, 'codigo_producto' => '113-60', 'producto' => 'Producto 42', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 82, 'codigo_producto' => 'V01 - V02', 'producto' => 'Producto 43', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 83, 'codigo_producto' => 'S06', 'producto' => 'Producto 44', 'id_ramo' => 16, 'id_estado' => 1],
        ['id_producto' => 84, 'codigo_producto' => '113', 'producto' => 'Producto 45', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 85, 'codigo_producto' => '112', 'producto' => 'Producto 46', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 86, 'codigo_producto' => 'AG7 - AG8 - RC4', 'producto' => 'Producto 47', 'id_ramo' => 6, 'id_estado' => 1],
        ['id_producto' => 87, 'codigo_producto' => 'RC3', 'producto' => 'Producto 48', 'id_ramo' => 6, 'id_estado' => 1],
        ['id_producto' => 88, 'codigo_producto' => '56-50', 'producto' => 'Producto 49', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 89, 'codigo_producto' => '56-51', 'producto' => 'Producto 50', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 90, 'codigo_producto' => '69', 'producto' => 'Producto 51', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 91, 'codigo_producto' => '55', 'producto' => 'Producto 52', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 92, 'codigo_producto' => '88', 'producto' => 'Producto 53', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 93, 'codigo_producto' => '66', 'producto' => 'Producto 54', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 94, 'codigo_producto' => 'SBYS', 'producto' => 'Producto 55', 'id_ramo' => 7, 'id_estado' => 1],
        ['id_producto' => 95, 'codigo_producto' => '12', 'producto' => 'Producto 56', 'id_ramo' => 11, 'id_estado' => 1],
        ['id_producto' => 96, 'codigo_producto' => '41', 'producto' => 'Producto 57', 'id_ramo' => 10, 'id_estado' => 1],
        ['id_producto' => 97, 'codigo_producto' => '118', 'producto' => 'Producto 58', 'id_ramo' => 3, 'id_estado' => 1],
        ['id_producto' => 98, 'codigo_producto' => '34', 'producto' => 'Producto 59', 'id_ramo' => 17, 'id_estado' => 1],
        ['id_producto' => 99, 'codigo_producto' => '620', 'producto' => 'Producto 60', 'id_ramo' => 5, 'id_estado' => 1],
        ['id_producto' => 100, 'codigo_producto' => '777', 'producto' => 'Producto 61', 'id_ramo' => 5, 'id_estado' => 1],
        ['id_producto' => 101, 'codigo_producto' => '40', 'producto' => 'Producto 62', 'id_ramo' => 18, 'id_estado' => 1],
        ['id_producto' => 102, 'codigo_producto' => 'AGE', 'producto' => 'Producto 63', 'id_ramo' => 18, 'id_estado' => 1],
        ['id_producto' => 103, 'codigo_producto' => '24', 'producto' => 'Producto 64', 'id_ramo' => 18, 'id_estado' => 1],
        ['id_producto' => 104, 'codigo_producto' => '1942', 'producto' => 'Producto 65', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 105, 'codigo_producto' => '173', 'producto' => 'Producto 66', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 106, 'codigo_producto' => 'VGSB', 'producto' => 'Producto 67', 'id_ramo' => 20, 'id_estado' => 1],
        ['id_producto' => 107, 'codigo_producto' => '83', 'producto' => 'Producto 68', 'id_ramo' => 20, 'id_estado' => 1],
        ['id_producto' => 108, 'codigo_producto' => '013T', 'producto' => 'Producto 69', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 109, 'codigo_producto' => '024T', 'producto' => 'Producto 70', 'id_ramo' => 19, 'id_estado' => 1],
        ['id_producto' => 110, 'codigo_producto' => '001T', 'producto' => 'Producto 71', 'id_ramo' => 19, 'id_estado' => 1],
    ];

    public static function cargarProductos()
    {
        foreach (self::$productos as $p) {
            DB::table('productos')->updateOrInsert(
                ['id_producto' => $p['id_producto']],
                [
                    'codigo_producto' => $p['codigo_producto'],
                    'producto' => $p['producto'],
                    'id_ramo' => $p['id_ramo'],
                    'id_estado' => $p['id_estado'],
                ]
            );
        }
    }
}
