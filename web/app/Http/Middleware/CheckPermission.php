<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\permisos\PermisosController;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        // Primero verificamos si hay sesión activa (como lo haces actualmente)
        if (!session('sesion_iniciada')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        // Obtenemos el nombre de la ruta actual (ej: 'usuarios.index')
        $routeName = $request->route()->getName();
        
        // Usamos tu mismo controlador de permisos
        $permisosController = app(PermisosController::class);

        // Verifica el permiso
        if (!$permisosController->tienePermisoRuta($routeName)) {
            // Si es una petición AJAX o espera HTML (por ejemplo, para cargar un modal)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->view('errores.permiso_modal', [
                    'mensaje' => 'No tienes permisos para realizar esta acción.'
                ], 403);
            }

            // Si es una petición normal (navegación clásica)
            return response()->view('errores.permiso_general', [
                'mensaje' => 'No tienes permisos para realizar esta acción.'
            ], 403);
        }

        return $next($request);
    }
}
