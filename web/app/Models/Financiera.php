<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Financiera extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'financieras';
    protected $primaryKey = 'id_financiera';
    public $timestamps = true;
    protected $fillable = [
        'financiera'
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
