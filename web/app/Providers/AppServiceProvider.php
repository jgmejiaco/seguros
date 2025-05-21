<?php

namespace App\Providers;
use Exception;
use Illuminate\Support\Facades\View;
use App\Models\Usuario;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.header', function ($view) {
            try {
                $idUsuario = session('id_usuario');

                // Datos del usuario
                $usuario = Usuario::leftJoin('roles', 'roles.id', '=', 'usuarios.id_rol')
                    ->where('id_usuario', $idUsuario)
                    ->select(
                        'nombre_usuario',
                        'apellido_usuario',
                        'usuarios.id_rol',
                        'name AS rol'
                    )
                    ->first();

                // Permisos
                $permisosController = app(\App\Http\Controllers\permisos\PermisosController::class);
                
                // Pasamos ambas variables
                $view->with([
                    'usuarioLogueado' => $usuario,
                    'permisos' => $permisosController
                ]);
            
            } catch (Exception $e) {
                alert()->error('Error', 'Exception al cargar datos de sesión');
                return back();
            }
        });
    }
}
