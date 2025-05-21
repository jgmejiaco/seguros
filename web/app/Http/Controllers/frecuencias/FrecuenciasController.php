<?php

namespace App\Http\Controllers\frecuencias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use App\Http\Responsable\frecuencias\FrecuenciaIndex;
use App\Http\Responsable\frecuencias\FrecuenciaStore;
use App\Http\Responsable\frecuencias\FrecuenciaUpdate;
use App\Http\Responsable\frecuencias\FrecuenciaEdit;

class FrecuenciasController extends Controller
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
                    return new FrecuenciaIndex();
                }
            }
        } catch (Exception $e) {
            alert()->error("Consultando las Frecuencias!");
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
                    return new FrecuenciaStore();
                }
            }
        } catch (Exception $e) {
            alert()->error("Creando la Frecuencia!");
            return redirect()->route('login');
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
    public function edit(string $idFrecuencia)
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
                    return new FrecuenciaEdit($idFrecuencia);
                }
            }
        } catch (Exception $e) {
            alert()->error("Editando la Frecuencia!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idFrecuencia)
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
                    return new FrecuenciaUpdate($idFrecuencia);
                }
            }
        } catch (Exception $e) {
            alert()->error("Actualizando la Frecuencia!");
            return redirect()->to(route('login'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idFrecuencia)
    {
        //
    }
}
