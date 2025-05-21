<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'estados';
    protected $primaryKey = 'id_estado';
    public $timestamps = true;
    protected $fillable = [
        'estado',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
