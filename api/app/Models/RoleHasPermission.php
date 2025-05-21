<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable; // Interfaz
use OwenIt\Auditing\Auditable as AuditableTrait; // Trait

class RoleHasPermission extends Model implements Auditable
{
    use AuditableTrait;

    protected $connection = 'mysql';
    protected $table = 'role_has_permissions';
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'role_id'
    ];
}
