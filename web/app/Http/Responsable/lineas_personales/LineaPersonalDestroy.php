<?php

namespace App\Http\Responsable\lineas_personales;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class LineaPersonalDestroy implements Responsable
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;
    protected $idLineasPersonal;

    public function __construct($idLineasPersonal)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idLineasPersonal = $idLineasPersonal;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $idLineasPersonal = $this->idLineasPersonal;
        
        // =============================================================

        try {
            $peticionEliminarRadicado = $this->clientApi->delete($this->baseUri . 'linea_personal_destroy/' . $idLineasPersonal, [
                'json' => []
            ]);
            $resEliminarRadicado = json_decode($peticionEliminarRadicado->getBody()->getContents());

            if (isset($resEliminarRadicado) && $resEliminarRadicado->success) {

                // ✅ Eliminar archivos locales
                $archivos = $resEliminarRadicado->archivos ?? [];
                foreach ($archivos as $archivo) {
                    if (Storage::disk('public')->exists($archivo)) {
                        Storage::disk('public')->delete($archivo);
                    }
                }

                alert()->success('Radicado eliminado exitosamente!.');
                return redirect()->route('lineas_personales.index');
            }

        } catch (Exception $e) {
            alert()->error('Error eliminando el Radicado, contacte a Soporte.');
            return redirect()->route('lineas_personales.index');
        }
    } // FIN toResponse($request)
}
