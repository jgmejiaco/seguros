<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// =====================================================================
// =====================================================================

// USUARIOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('usuarios_index', 'usuarios\UsuariosController@index');
    $router->post('query_correo_user', 'usuarios\UsuariosController@queryCorreoUser');
    $router->post('query_usuario', 'usuarios\UsuariosController@queryUsuario');
    $router->post('usuario_store', 'usuarios\UsuariosController@store');
    $router->post('inactivar_usuario/{idUsuario}', 'usuarios\UsuariosController@inactivarUsuario');
    $router->post('actualizar_clave_fallas/{idUsuario}', 'usuarios\UsuariosController@actualizarClaveFallas');
    $router->post('datos_usuario/{idUsuario}', 'usuarios\UsuariosController@datosUsuario');
    $router->put('usuario_update/{idUsuario}', 'usuarios\UsuariosController@update');
    $router->get('usuario_edit/{idUsuario}', 'usuarios\UsuariosController@edit');

    $router->post('cambiar_clave/{idUsuario}', 'usuarios\UsuariosController@cambiarClave');
    $router->post('cambiar_estado_usuario/{idUsuario}', 'usuarios\UsuariosController@destroy');

    $router->post('consulta_recuperar_clave', 'usuarios\UsuariosController@consultaRecuperarClave');
});

// =====================================================================
// =====================================================================

// LÍNEA PERSONAL
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('linea_personal_index', 'lineas_personales\LineasPersonalesController@index');
    $router->post('query_consultor/{idConsultor}', 'lineas_personales\LineasPersonalesController@queryConsultor');
    $router->post('query_producto/{idProducto}', 'lineas_personales\LineasPersonalesController@queryProducto');
    $router->post('linea_personal_store', 'lineas_personales\LineasPersonalesController@store');
    $router->get('linea_personal_edit/{idLineasPersonal}', 'lineas_personales\LineasPersonalesController@edit');
    $router->put('linea_personal_update/{idLineasPersonal}', 'lineas_personales\LineasPersonalesController@update');
    $router->delete('linea_personal_destroy/{idLineasPersonal}', 'lineas_personales\LineasPersonalesController@destroy');
});

// =====================================================================
// =====================================================================

// ASEGURADORAS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('aseguradora_index', 'aseguradoras\AseguradorasController@index');
    $router->post('consultar_aseguradora', 'aseguradoras\AseguradorasController@consultarAseguradora');
    $router->post('consultar_nit_aseguradora', 'aseguradoras\AseguradorasController@consultarNitAseguradora');
    $router->post('aseguradora_store', 'aseguradoras\AseguradorasController@store');
    $router->put('aseguradora_update/{idAseguradora}', 'aseguradoras\AseguradorasController@update');
    $router->get('aseguradora_edit/{idAseguradora}', 'aseguradoras\AseguradorasController@edit');
});

// =====================================================================
// =====================================================================

// CONSULTORES
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('consultor_index', 'consultores\ConsultoresController@index');
    $router->post('query_clave_consultor_global', 'consultores\ConsultoresController@queryClaveConsultorGlobal');
    $router->post('consultar_consultor', 'consultores\ConsultoresController@consultarConsultor');
    $router->post('consultor_store', 'consultores\ConsultoresController@store');
    $router->put('consultor_update/{idConsultor}', 'consultores\ConsultoresController@update');
    $router->get('consultor_edit/{idConsultor}', 'consultores\ConsultoresController@edit');
});

// =====================================================================
// =====================================================================

// FRECUENCIAS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('frecuencia_index', 'frecuencias\FrecuenciasController@index');
    $router->post('consultar_frecuencia', 'frecuencias\FrecuenciasController@consultarFrecuencia');
    $router->post('frecuencia_store', 'frecuencias\FrecuenciasController@store');
    $router->put('frecuencia_update/{idFrecuencia}', 'frecuencias\FrecuenciasController@update');
    $router->get('frecuencia_edit/{idFrecuencia}', 'frecuencias\FrecuenciasController@edit');
});

// =====================================================================
// =====================================================================

// ESTADOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('estado_index', 'estados\EstadosController@index');
    $router->post('consultar_estado', 'estados\EstadosController@consultarEstado');
    $router->post('estado_store', 'estados\EstadosController@store');
    $router->put('estado_update/{idEstado}', 'estados\EstadosController@update');
    $router->get('estado_edit/{idEstado}', 'estados\EstadosController@edit');
});

// =====================================================================
// =====================================================================

// GERENTES
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('gerente_index', 'gerentes\GerentesController@index');
    $router->post('consultar_gerente', 'gerentes\GerentesController@consultarGerente');
    $router->post('gerente_store', 'gerentes\GerentesController@store');
    $router->put('gerente_update/{idGerente}', 'gerentes\GerentesController@update');
});

// =====================================================================
// =====================================================================

// PRODUCTOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('producto_index', 'productos\ProductosController@index');
    $router->post('query_codigo_producto', 'productos\ProductosController@queryCodigoProducto');
    $router->post('consultar_producto', 'productos\ProductosController@consultarProducto');
    $router->post('producto_store', 'productos\ProductosController@store');
    $router->put('producto_update/{idProducto}', 'productos\ProductosController@update');
    $router->put('producto_edit/{idProducto}', 'productos\ProductosController@edit');
});

// =====================================================================
// =====================================================================

// RAMOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('ramo_index', 'ramos\RamosController@index');
    $router->post('consultar_ramo', 'ramos\RamosController@consultarRamo');
    $router->post('ramo_store', 'ramos\RamosController@store');
    $router->put('ramo_update/{idRamo}', 'ramos\RamosController@update');
    $router->get('ramo_edit/{idRamo}', 'ramos\RamosController@edit');
});

// =====================================================================
// =====================================================================

// ROLES
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('rol_index', 'roles\RolesController@index');
    $router->post('consultar_rol', 'roles\RolesController@consultarRol');
    $router->post('rol_store', 'roles\RolesController@store');
    $router->put('rol_update/{idRol}', 'roles\RolesController@update');
    $router->get('rol_edit/{idRol}', 'roles\RolesController@edit');
});

// =====================================================================
// =====================================================================

// PERMISOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('permiso_index', 'permisos\PermisosController@index');
    $router->post('permiso_store', 'permisos\PermisosController@store');
    $router->get('permiso_edit/{idPermiso}', 'permisos\PermisosController@edit');
    $router->put('permiso_update/{idPermiso}', 'permisos\PermisosController@update');
});

// =====================================================================
// =====================================================================

// ASIGNAR PERMISOS
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('asignar_permiso_index', 'asignar_permisos\AsignarPermisosController@index');
    $router->get('consultar_permisos_rol', 'asignar_permisos\AsignarPermisosController@consultarPermisosRol');
    $router->post('asignar_permiso_rol', 'asignar_permisos\AsignarPermisosController@store');
});