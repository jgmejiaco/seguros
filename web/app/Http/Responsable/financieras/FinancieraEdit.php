<?php

namespace App\Http\Responsable\financieras;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class FinancieraEdit implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idFinanciera;

    public function __construct($idFinanciera)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idFinanciera = $idFinanciera;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $peticionFinancieraEdit = $this->clientApi->get($this->baseUri . 'financiera_edit/' . $this->idFinanciera, [
                'json' => []
            ]);
            $resFinancieraEdit = json_decode($peticionFinancieraEdit->getBody()->getContents());

            if (isset($resFinancieraEdit)) {
                return view('financieras.modal_editar_financiera', compact('resFinancieraEdit'));
            }

        } catch (Exception $e) {
            alert()->error('Error editando la Financiera, contacte a Soporte.');
            return redirect()->route('financieras.index');
        }
    } // FIN toResponse($request)
} // FIN Class EstadoEdit
