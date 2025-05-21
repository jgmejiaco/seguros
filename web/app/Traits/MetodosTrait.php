<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Rol;
use App\Models\Estado;
use App\Models\Aseguradora;
use App\Models\Consultor;
use App\Models\Frecuencia;
use App\Models\Gerente;
use App\Models\Producto;
use App\Models\Ramo;
use App\Models\Tomador;
use App\Models\Usuario;
use App\Models\Permission;
use App\Models\RoleHasPermission;

trait MetodosTrait
{
    public function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return true; // Conexión exitosa
        } catch (\Exception $e) {
            return false; // Conexión fallida
        }
    }

    // ======================================

    public function validarVariablesSesion()
    {
        $variablesSesion =[];

        $idUsuario = session('id_usuario');
        array_push($variablesSesion, $idUsuario);

        $usuario = session('usuario');
        array_push($variablesSesion, $usuario);

        $rolUsuario = session('id_rol');
        array_push($variablesSesion, $rolUsuario);

        $sesionIniciada = session('sesion_iniciada');
        array_push($variablesSesion, $sesionIniciada);

        return $variablesSesion;
    }

    // ======================================

    public function quitarCaracteresEspeciales($cadena)
    {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ",
        "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ","Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢",
        "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”","Ã›", "ü", "Ã¶", "Ã–", "Ã¯",
        "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "ñ", "Ñ", "*");

        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U",
                            "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U",
                            "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "n", "N", "");
        return str_replace($no_permitidas, $permitidas, $cadena);
    }

    // ======================================

    function tienePermisoRuta($routeName)
    {
        $idRol = session('id_rol');

        // Busca el id del permiso asociado a la ruta
        $permiso = Permission::where('route_name', $routeName)->first();

        if (!$permiso) {
            return false; // Ruta no asociada a permiso
        }

        // Verifica si el rol tiene ese permiso
        return RoleHasPermission::where('role_id', $idRol)
            ->where('permission_id', $permiso->id)
            ->exists();
    }

    // ======================================

    public function shareData()
    {
        view()->share('estados', Estado::orderBy('estado','asc')->pluck('estado', 'id_estado'));
        view()->share('estados_gral', Estado::whereIn('id_estado',[1,2])->orderBy('estado','asc')->pluck('estado', 'id_estado'));
        view()->share('roles', Rol::orderBy('name','asc')->pluck('name', 'id'));

        view()->share('aseguradoras', Aseguradora::select(
            DB::raw("CONCAT(nit_aseguradora, ' - ', aseguradora) AS aseguradoras"),
            'id_aseguradora'
        )
        ->orderBy('aseguradora', 'asc')
        ->pluck('aseguradoras', 'id_aseguradora'));

        view()->share('consultores', Consultor::orderBy('clave_consultor_global','asc')->pluck('clave_consultor_global', 'id_consultor'));

        view()->share('frecuencias', Frecuencia::orderBy('frecuencia','asc')->pluck('frecuencia', 'id_frecuencia'));
        view()->share('gerentes', Gerente::orderBy('gerente','asc')->pluck('gerente', 'id_gerente'));

        view()->share('productos', Producto::select(
            DB::raw("CONCAT(codigo_producto, ' - ', producto) AS productos"),
            'id_producto'
        )
        ->orderBy('producto', 'asc')
        ->pluck('productos', 'id_producto'));

        view()->share('ramos', Ramo::orderBy('ramo','asc')->pluck('ramo', 'id_ramo'));

        view()->share('tomadores', Tomador::select(
            DB::raw("CONCAT(identificacion_tomador, ' - ', tomador) AS nombre_completo"),
            'id_tomador'
        )
        ->orderBy('tomador', 'asc')
        ->pluck('nombre_completo', 'id_tomador'));

        // ======================================
    }
}
