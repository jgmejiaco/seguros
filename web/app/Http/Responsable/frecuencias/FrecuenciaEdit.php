<?php

namespace App\Http\Responsable\frecuencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FrecuenciaEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idFrecuencia;

    public function __construct($idFrecuencia)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idFrecuencia = $idFrecuencia;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionFrecuenciaEdit = $this->clientApi->get($this->baseUri . 'frecuencia_edit/' . $this->idFrecuencia, [
                'json' => []
            ]);
            $resFrecuenciaEdit = json_decode($peticionFrecuenciaEdit->getBody()->getContents());

            return view('frecuencias.modal_editar_frecuencia', compact('resFrecuenciaEdit'));

        } catch (Exception $e) {
            alert()->error('Error consultando la Frecuencia, contacte a Soporte.');
            return redirect()->route('frecuencias.index');
        }
    }
}
