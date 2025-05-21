<?php

namespace App\Http\Controllers\asignar_permisos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\asignar_permisos\AsignarPermisoIndex;
use App\Http\Responsable\asignar_permisos\AsignarPermisoStore;

class AsignarPermisosController extends Controller
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->shareData();
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    public function index()
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else {
                    return new AsignarPermisoIndex();
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando los Permisos Asignados!");
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else {
                    return new AsignarPermisoStore();
                }
            }
        } catch (Exception $e) {
            alert()->error("Asignando el Permiso!");
            return back();
        }
    }

    public function consultarPermisosRol(Request $request)
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->route('login');
                } else {
                    $rol = request('id_rol', null);

                    $peticionPermisos = $this->clientApi->get($this->baseUri . 'consultar_permisos_rol', [
                        'json' => ['id_rol' => $rol]
                    ]);

                    return $peticionPermisos->getBody()->getContents();
                }
            }
            
        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }
} // FIN Class AsignarPermisosController
