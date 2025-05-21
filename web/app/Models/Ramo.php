<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ramo extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'ramos';
    protected $primaryKey = 'id_ramo';
    public $timestamps = true;
    protected $fillable = [
        'ramo',
        'id_estado'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
