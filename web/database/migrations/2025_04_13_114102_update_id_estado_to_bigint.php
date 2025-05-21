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
        // 1. Eliminar foreign keys
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_proceso']);
            $table->dropForeign(['id_estado_inicial']);
            $table->dropForeign(['id_estado_poliza']);
        });

        // 2. Cambiar tipo en la tabla principal
        Schema::table('estados', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->change();
        });

        // 3. Cambiar tipo en las columnas que dependen
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->change();
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proceso')->nullable()->change();
            $table->unsignedBigInteger('id_estado_inicial')->nullable()->change();
            $table->unsignedBigInteger('id_estado_poliza')->nullable()->change();
        });

        // 4. Volver a agregar las foreign keys
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_proceso')->references('id_estado')->on('estados');
            $table->foreign('id_estado_inicial')->references('id_estado')->on('estados');
            $table->foreign('id_estado_poliza')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios en caso de rollback
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_proceso']);
            $table->dropForeign(['id_estado_inicial']);
            $table->dropForeign(['id_estado_poliza']);
        });

        Schema::table('estados', function (Blueprint $table) {
            $table->unsignedInteger('id_estado')->change();
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedInteger('id_estado')->nullable()->change();
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedInteger('id_proceso')->nullable()->change();
            $table->unsignedInteger('id_estado_inicial')->nullable()->change();
            $table->unsignedInteger('id_estado_poliza')->nullable()->change();
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_proceso')->references('id_estado')->on('estados');
            $table->foreign('id_estado_inicial')->references('id_estado')->on('estados');
            $table->foreign('id_estado_poliza')->references('id_estado')->on('estados');
        });
    }
};
