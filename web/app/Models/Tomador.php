<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tomador extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'tomadores';
    protected $primaryKey = 'id_tomador';
    public $timestamps = true;
    protected $fillable = [
        'identificacion_tomador',
        'tomador',
        'id_estado'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
