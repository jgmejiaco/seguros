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
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->string('direccion_tomador')->nullable()->after('tomador');
            $table->string('celular_tomador')->nullable()->after('direccion_tomador');
            $table->string('correo_tomador')->nullable()->after('celular_tomador');
            $table->string('fecha_nacimiento')->nullable()->after('correo_tomador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropColumn('direccion_tomador');
            $table->dropColumn('celular_tomador');
            $table->dropColumn('correo_tomador');
            $table->dropColumn('fecha_nacimiento');
        });
    }
};
