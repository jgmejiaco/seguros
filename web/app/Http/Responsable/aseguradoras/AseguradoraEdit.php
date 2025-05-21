<?php

namespace App\Http\Responsable\aseguradoras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class AseguradoraEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idAseguradora;

    public function __construct($idAseguradora)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idAseguradora = $idAseguradora;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionAseguradoraEdit = $this->clientApi->get($this->baseUri . 'aseguradora_edit/' . $this->idAseguradora, [
                'json' => []
            ]);
            $resAseguradoraEdit = json_decode($peticionAseguradoraEdit->getBody()->getContents());

            return view('aseguradoras.modal_editar_aseguradora', compact('resAseguradoraEdit'));

        } catch (Exception $e) {
            alert()->error('Error consultando la Aseguradora, contacte a Soporte.');
            return redirect()->route('aseguradoras.index');
        }
    }
}
