<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'usuarios' => 'id_usuario',
            'lineas_personales' => 'id_lineas_personal',
            'consultores' => 'id_consultor',
            'estados' => 'id_estado',
            'aseguradoras' => 'id_aseguradora',
            'frecuencias' => 'id_frecuencia',
            'gerentes' => 'id_gerente',
            'productos' => 'id_producto',
            'ramos' => 'id_ramo',
            'tomadores' => 'id_tomador',
        ];

        foreach ($tables as $tableName => $columnName) {
            Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                $table->bigIncrements($columnName)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'usuarios' => 'id_usuario',
            'lineas_personales' => 'id_lineas_personal',
            'consultores' => 'id_consultor',
            'estados' => 'id_estado',
            'aseguradoras' => 'id_aseguradora',
            'frecuencias' => 'id_frecuencia',
            'gerentes' => 'id_gerente',
            'productos' => 'id_producto',
            'ramos' => 'id_ramo',
            'tomadores' => 'id_tomador',
        ];

        foreach ($tables as $tableName => $columnName) {
            Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                $table->bigInteger($columnName)->unsigned()->change();
                $table->primary($columnName);
                $table->autoIncrement(false);
            });
        }
    }
};
