<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable; // Interfaz
use OwenIt\Auditing\Auditable as AuditableTrait; // Trait

class ModelHasRoles extends Model implements Auditable
{
    use AuditableTrait;

    protected $connection = 'mysql';
    protected $table = 'model_has_roles';
    public $timestamps = false;
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];
}
