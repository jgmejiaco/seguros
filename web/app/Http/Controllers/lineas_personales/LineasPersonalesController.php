<?php

namespace App\Http\Controllers\lineas_personales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use App\Http\Responsable\lineas_personales\LineaPersonalIndex;
use App\Http\Responsable\lineas_personales\LineaPersonalStore;
use App\Http\Responsable\lineas_personales\LineaPersonalEdit;
use App\Http\Responsable\lineas_personales\LineaPersonalUpdate;
use App\Http\Responsable\lineas_personales\LineaPersonalDestroy;
use App\Http\Responsable\lineas_personales\QueryConsultor;
use App\Http\Responsable\lineas_personales\QueryProducto;

class LineasPersonalesController extends Controller
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

    // ================================================
    /**
     * Display a listing of the resource.
     */
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
                    return new LineaPersonalIndex();
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando los Radicados!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
                    return view('lineas_personales.create');
                }
            }
        } catch (Exception $e) {
            alert()->error("Creando el Radicado!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
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
                    return new LineaPersonalStore();
                }
            }
        } catch (Exception $e) {
            alert()->error("Guardando el Radicado!!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idLineasPersonal)
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
                    // ✅ Instanciar y llamar toResponse()
                    $lineaPersonalEdit = new LineaPersonalEdit($idLineasPersonal);
                    $resLineaPersonalEdit = $lineaPersonalEdit->toResponse(request());

                    return view('lineas_personales.edit', compact('resLineaPersonalEdit'));
                }
            }
        } catch (Exception $e) {
            alert()->error("Editando el Radicado!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idLineasPersonal)
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
                    return new LineaPersonalUpdate($idLineasPersonal);
                }
            }
        } catch (Exception $e) {
            alert()->error("Actualizando el Radicado!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idLineasPersonal)
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
                    return new LineaPersonalDestroy($idLineasPersonal);
                }
            }
        } catch (Exception $e) {
            alert()->error("Eliminando el Radicado!");
            return redirect()->to(route('login'));
        }
    }

    public function consultaEliminarRadicado(string $idLineasPersonal)
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
                    // ✅ Instanciar y llamar toResponse()
                    $lineaPersonalEdit = new LineaPersonalEdit($idLineasPersonal);
                    $resLineaPersonalEdit = $lineaPersonalEdit->toResponse(request());

                    return view('lineas_personales.modal_eliminar_radicado', compact('resLineaPersonalEdit'));
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando el Radicado!");
            return redirect()->to(route('login'));
        }
    }

    public function queryConsultor()
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
                    return new QueryConsultor();
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando el consultor!");
            return redirect()->route('login');
        }
    }
    
    public function queryProducto()
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
                    return new QueryProducto();
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando el Productor!");
            return redirect()->route('login');
        }
    }
}
