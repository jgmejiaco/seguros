<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gerente extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'gerentes';
    protected $primaryKey = 'id_gerente';
    public $timestamps = true;
    protected $fillable = [
        'gerente',
        'id_estado'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
