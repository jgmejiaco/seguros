<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;

class PermisosHelper
{
    protected static $permisos = [
        ['name' => 'Usuario Ver', 'guard_name' => 'API', 'route_name' => 'usuarios.index'],
        ['name' => 'Usuario Crear', 'guard_name' => 'API', 'route_name' => 'usuarios.store'],
        ['name' => 'Permisos Asignados Ver', 'guard_name' => 'API', 'route_name' => 'asignar_permisos.index'],
        ['name' => 'Radicado Ver', 'guard_name' => 'API', 'route_name' => 'lineas_personales.index'],
        ['name' => 'Radicado Crear', 'guard_name' => 'API', 'route_name' => 'lineas_personales.create'],
        ['name' => 'Aseguradoras Ver', 'guard_name' => 'API', 'route_name' => 'aseguradoras.index'],
        ['name' => 'Consultores Ver', 'guard_name' => 'API', 'route_name' => 'consultores.index'],
        ['name' => 'Estados Ver', 'guard_name' => 'API', 'route_name' => 'estados.index'],
        ['name' => 'Frecuencias Ver', 'guard_name' => 'API', 'route_name' => 'frecuencias.index'],
        ['name' => 'Producto Ver', 'guard_name' => 'API', 'route_name' => 'productos.index'],
        ['name' => 'Ramo Ver', 'guard_name' => 'API', 'route_name' => 'ramos.index'],
        ['name' => 'Roles Ver', 'guard_name' => 'API', 'route_name' => 'roles.index'],
        ['name' => 'Radicado Editar', 'guard_name' => 'API', 'route_name' => 'lineas_personales.edit'],
        ['name' => 'Radicado Guardar', 'guard_name' => 'API', 'route_name' => 'lineas_personales.store'],
        ['name' => 'Radicado Actualizar', 'guard_name' => 'API', 'route_name' => 'lineas_personales.update'],
        ['name' => 'Radicado Eliminar', 'guard_name' => 'API', 'route_name' => 'lineas_personales.destroy'],
        ['name' => 'Permisos Asignados Crear', 'guard_name' => 'API', 'route_name' => 'asignar_permisos.store'],
        ['name' => 'Aseguradora Crear', 'guard_name' => 'API', 'route_name' => 'aseguradoras.store'],
        ['name' => 'Aseguradora Actualizar', 'guard_name' => 'API', 'route_name' => 'aseguradoras.update'],
        ['name' => 'Consultor Crear', 'guard_name' => 'API', 'route_name' => 'consultores.store'],
        ['name' => 'Consultor Actualizar', 'guard_name' => 'API', 'route_name' => 'consultores.update'],
        ['name' => 'Estado Crear', 'guard_name' => 'API', 'route_name' => 'estados.store'],
        ['name' => 'Estado Actualizar', 'guard_name' => 'API', 'route_name' => 'estados.update'],
        ['name' => 'Frecuencia Crear', 'guard_name' => 'API', 'route_name' => 'frecuencias.store'],
        ['name' => 'Frecuencia Actualizar', 'guard_name' => 'API', 'route_name' => 'frecuencias.update'],
        ['name' => 'Producto Crear', 'guard_name' => 'API', 'route_name' => 'productos.store'],
        ['name' => 'Producto Actualizar', 'guard_name' => 'API', 'route_name' => 'productos.update'],
        ['name' => 'Ramo Crear', 'guard_name' => 'API', 'route_name' => 'ramos.store'],
        ['name' => 'Ramo Actualizar', 'guard_name' => 'API', 'route_name' => 'ramos.update'],
        ['name' => 'Rol Crear', 'guard_name' => 'API', 'route_name' => 'roles.store'],
        ['name' => 'Rol Actualizar', 'guard_name' => 'API', 'route_name' => 'roles.update'],
        ['name' => 'Permiso Crear', 'guard_name' => 'API', 'route_name' => 'permisos.store'],
        ['name' => 'Permisos Asignados Consultar Rol', 'guard_name' => 'API', 'route_name' => 'consultar_permisos_rol'],
        ['name' => 'Permiso Ver', 'guard_name' => 'API', 'route_name' => 'permisos.index'],
        ['name' => 'Permiso Actualizar', 'guard_name' => 'API', 'route_name' => 'permisos.update'],
        ['name' => 'Usuario Actualizar', 'guard_name' => 'API', 'route_name' => 'usuarios.update'],
        ['name' => 'Usuario Inactivar', 'guard_name' => 'API', 'route_name' => 'usuarios.destroy'],
        ['name' => 'Permiso Edit', 'guard_name' => 'API', 'route_name' => 'permisos.edit'],
        ['name' => 'Producto Edit', 'guard_name' => 'API', 'route_name' => 'productos.edit'],
        ['name' => 'Estado Edit', 'guard_name' => 'API', 'route_name' => 'estados.edit'],
        ['name' => 'Ramo Edit', 'guard_name' => 'API', 'route_name' => 'ramos.edit'],
        ['name' => 'Aseguradora Edit', 'guard_name' => 'API', 'route_name' => 'aseguradoras.edit'],
        ['name' => 'Consultor Edit', 'guard_name' => 'API', 'route_name' => 'consultores.edit'],
        ['name' => 'Frecuencia Edit', 'guard_name' => 'API', 'route_name' => 'frecuencias.edit'],
        ['name' => 'Rol Edit', 'guard_name' => 'API', 'route_name' => 'roles.edit'],
        ['name' => 'Usuario Edit', 'guard_name' => 'API', 'route_name' => 'usuarios.edit'],
    ];

    public static function cargarPermisos()
    {
        foreach (self::$permisos as $permiso) {
            Permission::firstOrCreate(
                ['route_name' => $permiso['route_name']],
                ['name' => $permiso['name'], 'guard_name' => $permiso['guard_name']]
            );
        }
    }
}
