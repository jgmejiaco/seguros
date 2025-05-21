<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = true;
    protected $fillable = [
        'codigo_producto',
        'producto',
        'id_ramo',
        'id_estado'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
