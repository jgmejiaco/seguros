<?php

namespace App\Http\Responsable\audits;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Audit;

class AuditIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $audits = Audit::leftJoin('usuarios', 'usuarios.id_usuario', '=', 'audits.user_id')
                ->select(
                    'id',
                    'user_type',
                    'event',
                    'auditable_type',
                    'auditable_id',
                    'old_values',
                    'new_values',
                    'url',
                    'ip_address',
                    'user_agent',
                    'tags',
                    'usuarios.id_usuario',
                    'usuarios.usuario'
                )
                ->orderByDesc('id')
                ->get();

            return response()->json($audits);
            
        } catch (Exception $e) {
            return response()->json(['error_exception' => $e->getMessage()], 500);
        }
    }
}
