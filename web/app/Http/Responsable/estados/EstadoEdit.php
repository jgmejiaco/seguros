<?php

namespace App\Http\Responsable\estados;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class EstadoEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idEstado;

    public function __construct($idEstado)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idEstado = $idEstado;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionEstadoEdit = $this->clientApi->get($this->baseUri . 'estado_edit/' . $this->idEstado, [
                'json' => []
            ]);
            $resEstadoEdit = json_decode($peticionEstadoEdit->getBody()->getContents());

            if (isset($resEstadoEdit)) {
                return view('estados.modal_editar_estado', compact('resEstadoEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error editando el estado, contacte a Soporte.');
            return redirect()->route('productos.index');
        }
    } // FIN toResponse($request)
} // FIN Class EstadoEdit
