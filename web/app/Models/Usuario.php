<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Model
{
    use SoftDeletes;
    use HasRoles;

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
}
