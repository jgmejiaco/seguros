<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable; // Interfaz
use OwenIt\Auditing\Auditable as AuditableTrait; // Trait

use Spatie\Permission\Traits\HasRoles;

class Usuario extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    protected $connection = 'mysql';
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;
    protected $fillable = [
        'nombre_usuario',
        'apellido_usuario',
        'correo',
        'id_estado',
        'id_rol',
        'usuario',
        'clave',
        'clave_fallas'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    public function getAuthIdentifier()
    {
        return $this->id_usuario;
    }
}
