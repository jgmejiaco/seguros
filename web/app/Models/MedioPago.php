<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedioPago extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'medios_pago';
    protected $primaryKey = 'id_medio_pago';
    public $timestamps = true;
    protected $fillable = [
        'medio_pago'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
