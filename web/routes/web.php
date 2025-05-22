<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inicio_sesion\LoginController;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\usuarios\UsuariosController;
use App\Http\Controllers\lineas_personales\LineasPersonalesController;
use App\Http\Controllers\asignar_permisos\AsignarPermisosController;
use App\Http\Controllers\permisos\PermisosController;
use App\Http\Controllers\aseguradoras\AseguradorasController;
use App\Http\Controllers\consultores\ConsultoresController;
use App\Http\Controllers\estados\EstadosController;
use App\Http\Controllers\financieras\FinancierasController;
use App\Http\Controllers\frecuencias\FrecuenciasController;
use App\Http\Controllers\medios_pago\MediosPagoController;
use App\Http\Controllers\gerentes\GerentesController;
use App\Http\Controllers\productos\ProductosController;
use App\Http\Controllers\ramos\RamosController;
use App\Http\Controllers\roles\RolesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web', 'prevent-back-history'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('login');

    // ===========================================================================
    // ===========================================================================

    // Rutas públicas
    Route::redirect('/', '/login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    // ===========================================================================
    // ===========================================================================

    // LOGIN
    Route::controller(LoginController::class)->group(function () {
        Route::resource('login', LoginController::class);
        Route::get('login_usuario', 'index')->name('login_usuario');
        Route::get('logout', 'logout')->name('logout');

        // CAMBIAR CLAVE
        Route::post('cambiar_clave', 'cambiarClave')->name('cambiar_clave');

        // RECUPERAR CLAVE
        Route::get('recuperar_clave', 'recuperarClave')->name('recuperar_clave');
        Route::post('recuperar_clave_email', 'recuperarClaveEmail')->name('recuperar_clave_email');
        Route::get('recuperar_clave_link/{usuIdRecuperarClave}', 'recuperarClaveLink')->name('recuperar_clave_link');
        Route::post('recuperar_clave_update', 'recuperarClaveUpdate')->name('recuperar_clave_update');
    });

    // ===========================================================================
    // ===========================================================================

    // INICIO (Al iniciar sesión)
    Route::resource('inicio', HomeController::class);

    // ===========================================================================
    // ===========================================================================

    // USUARIOS
    Route::controller(UsuariosController::class)->group(function () {
        Route::resource('usuarios', UsuariosController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // INFORME PRODUCCIÓN LÍNEAS PERSONALES
    Route::controller(LineasPersonalesController::class)->group(function () {
        Route::resource('lineas_personales', LineasPersonalesController::class)->middleware('permission');
        Route::post('query_consultor', 'queryConsultor')->name('query_consultor');
        Route::post('query_producto', 'queryProducto')->name('query_producto');
        Route::get('eliminar_radicado/{idLineasPersonal}', 'consultaEliminarRadicado')->name('eliminar_radicado');
    });

    // ===========================================================================
    // ===========================================================================
    
    // ASEGURADORAS
    Route::controller(AseguradorasController::class)->group(function () {
        Route::resource('aseguradoras', AseguradorasController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
        
    // CONSULTORES
    Route::controller(ConsultoresController::class)->group(function () {
        Route::resource('consultores', ConsultoresController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
            
    // ESTADOS
    Route::controller(EstadosController::class)->group(function () {
        Route::resource('estados', EstadosController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // FRECUENCIAS
    Route::controller(FrecuenciasController::class)->group(function () {
        Route::resource('frecuencias', FrecuenciasController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
    
    // FINANCIERAS
    Route::controller(FinancierasController::class)->group(function () {
        Route::resource('financieras', FinancierasController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
        
    // MEDIO DE PAGO
    Route::controller(MediosPagoController::class)->group(function () {
        Route::resource('medios_pago', MediosPagoController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
    
    // GERENTES
    Route::controller(GerentesController::class)->group(function () {
        Route::resource('gerentes', GerentesController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================
    
    // PRODUCTOS
    Route::controller(ProductosController::class)->group(function () {
        Route::resource('productos', ProductosController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // RAMOS
    Route::controller(RamosController::class)->group(function () {
        Route::resource('ramos', RamosController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // ROLES
    Route::controller(RolesController::class)->group(function () {
        Route::resource('roles', RolesController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // PERMISOS
    Route::controller(PermisosController::class)->group(function () {
        Route::resource('permisos', PermisosController::class)->middleware('permission');
    });

    // ===========================================================================
    // ===========================================================================

    // ASIGNAR PERMISOS
    Route::controller(AsignarPermisosController::class)->group(function () {
        Route::resource('asignar_permisos', AsignarPermisosController::class)->middleware('permission');
        Route::get('consultar_permisos_rol', 'consultarPermisosRol')->name('consultar_permisos_rol')->middleware('permission');
    });
}); // FIN Route::middleware(['web', 'prevent-back-history'])
