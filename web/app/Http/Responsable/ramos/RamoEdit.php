<?php

namespace App\Http\Responsable\ramos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class RamoEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idRamo;

    public function __construct($idRamo)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idRamo = $idRamo;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionRamoEdit = $this->clientApi->get($this->baseUri . 'ramo_edit/' . $this->idRamo, [
                'json' => []
            ]);
            $resRamoEdit = json_decode($peticionRamoEdit->getBody()->getContents());

            return view('ramos.modal_editar_ramo', compact('resRamoEdit'));

        } catch (Exception $e) {
            alert()->error('Error editando el ramo, contacte a Soporte.');
            return redirect()->route('ramos.index');
        }
    } // FIN toResponse($request)
}
