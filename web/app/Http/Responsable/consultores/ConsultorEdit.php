<?php

namespace App\Http\Responsable\consultores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class ConsultorEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idConsultor;

    public function __construct($idConsultor)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idConsultor = $idConsultor;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $idConsultor = $this->idConsultor;
        
        // =============================================================

        try {
            $peticionEditConsultor = $this->clientApi->get($this->baseUri . 'consultor_edit/' . $idConsultor, [
                'json' => []
            ]);
            $resConsultorEdit = json_decode($peticionEditConsultor->getBody()->getContents());

            if (isset($resConsultorEdit)) {
                return view('consultores.modal_editar', compact('resConsultorEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error consultando el consultor, contacte a Soporte.');
            return redirect()->route('consultores.index');
        }
    } // FIN toResponse($request)
}
