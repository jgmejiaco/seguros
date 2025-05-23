<?php

namespace App\Http\Controllers\usuarios;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Responsable\usuarios\UsuarioIndex;
use App\Http\Responsable\usuarios\UsuarioStore;
use App\Http\Responsable\usuarios\UsuarioUpdate;
use App\Http\Responsable\usuarios\DatosUsuario;
use App\Http\Responsable\usuarios\UsuarioDestroy;
use App\Http\Responsable\usuarios\UsuarioEdit;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UsuarioIndex();
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new UsuarioStore($request);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idUsuario)
    {
        return new UsuarioEdit($idUsuario);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idUsuario)
    {
        return new UsuarioUpdate($idUsuario);
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idUsuario)
    {
        return new UsuarioDestroy($idUsuario);
    }

    // ======================================================================
    // ======================================================================

    public function queryCorreoUser()
    {
        try {
            $correo = request('correo', null);
        
            // Consultamos si ya existe este correo
            $queryCorreoUser = Usuario::where('correo', $correo)->first();

            if(isset($queryCorreoUser) && !is_null($queryCorreoUser)) {
                return response()->json('si_correo');
            } else {
                return response()->json('no_correo');
            }

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function queryUsuario()
    {
        try {
            $usuario = request('usuario', null);

            // Consultamos si ya existe este usuario específico
            $consultaUsuario = Usuario::where('usuario', $usuario)->first();

            return response()->json($consultaUsuario);

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function inactivarUsuario($idUsuario)
    {
        try {
            $user = Usuario::findOrFail($idUsuario);
            $user->id_estado = 2;
            $user->save();

        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function actualizarClaveFallas(Request $request, $idUsuario)
    {
        $contador = request('clave_fallas', null);

        try {
            $user = Usuario::find($idUsuario);
            $user->clave_fallas = $contador;
            $user->save();
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function datosUsuario($idUsuario)
    {
        return new DatosUsuario($idUsuario);
    }

    // ======================================================================
    // ======================================================================

    public function cambiarClave(Request $request, $idUsuario)
    {
        $claveNueva = $request->input('clave');

        try {
            Usuario::where('id_usuario',$idUsuario)
                ->update([
                    'clave' => $claveNueva,
            ]);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================

    public function consultaRecuperarClave(Request $request)
    {
        $correo = $request->input('correo');

        try {
             return Usuario::select('id_usuario','usuario','correo')
                ->where('correo', $correo)
                ->first();
        } catch (Exception $e) {
            return response()->json(['error_exception'=>$e->getMessage()]);
        }
    }

    // ======================================================================
    // ======================================================================
}
