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
        // 1. Eliminar foreign key en lineas_personales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });

        // 2. Cambiar tipo de id_usuario en usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->change();
        });

        // 3. Cambiar tipo de id_usuario en lineas_personales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->nullable()->change();
        });

        // 4. Volver a crear la foreign key
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // 1. Eliminar nuevamente la foreign key
         Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });

        // 2. Revertir tipo de id_usuario en usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedInteger('id_usuario')->change();
        });

        // 3. Revertir tipo de id_usuario en lineas_personales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedInteger('id_usuario')->nullable()->change();
        });

        // 4. Volver a crear la foreign key original
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }
};
