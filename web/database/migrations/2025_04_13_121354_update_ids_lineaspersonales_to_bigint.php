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
        // 1. Quitar claves foráneas
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_aseguradora']);
            $table->dropForeign(['id_tomador']);
            $table->dropForeign(['id_producto']);
            $table->dropForeign(['id_ramo']);
            $table->dropForeign(['id_frecuencia']);
            $table->dropForeign(['id_consultor']);
            $table->dropForeign(['id_gerente']);
        });

        // 2. Cambiar columnas de lineas_personales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lineas_personal')->change();
            $table->unsignedBigInteger('id_aseguradora')->nullable()->change();
            $table->unsignedBigInteger('id_tomador')->nullable()->change();
            $table->unsignedBigInteger('id_producto')->nullable()->change();
            $table->unsignedBigInteger('id_ramo')->nullable()->change();
            $table->unsignedBigInteger('id_frecuencia')->nullable()->change();
            $table->unsignedBigInteger('id_consultor')->nullable()->change();
            $table->unsignedBigInteger('id_gerente')->nullable()->change();
        });

        // 3. Cambiar columnas en tablas referenciadas
        Schema::table('aseguradoras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_aseguradora')->change();
        });

        Schema::table('tomadores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tomador')->change();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_producto')->change();
        });

        Schema::table('ramos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ramo')->change();
        });

        Schema::table('frecuencias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_frecuencia')->change();
        });

        Schema::table('consultores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consultor')->change();
        });

        Schema::table('gerentes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_gerente')->change();
        });

        // 4. Rehacer claves foráneas
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_aseguradora')->references('id_aseguradora')->on('aseguradoras');
            $table->foreign('id_tomador')->references('id_tomador')->on('tomadores');
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            $table->foreign('id_ramo')->references('id_ramo')->on('ramos');
            $table->foreign('id_frecuencia')->references('id_frecuencia')->on('frecuencias');
            $table->foreign('id_consultor')->references('id_consultor')->on('consultores');
            $table->foreign('id_gerente')->references('id_gerente')->on('gerentes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Quitar foráneas nuevas
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropForeign(['id_aseguradora']);
            $table->dropForeign(['id_tomador']);
            $table->dropForeign(['id_producto']);
            $table->dropForeign(['id_ramo']);
            $table->dropForeign(['id_frecuencia']);
            $table->dropForeign(['id_consultor']);
            $table->dropForeign(['id_gerente']);
        });

        // 2. Restaurar tipos originales en lineas_personales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->unsignedInteger('id_lineas_personal')->change();
            $table->unsignedInteger('id_aseguradora')->nullable()->change();
            $table->unsignedInteger('id_tomador')->nullable()->change();
            $table->unsignedInteger('id_producto')->nullable()->change();
            $table->unsignedInteger('id_ramo')->nullable()->change();
            $table->unsignedInteger('id_frecuencia')->nullable()->change();
            $table->unsignedInteger('id_consultor')->nullable()->change();
            $table->unsignedInteger('id_gerente')->nullable()->change();
        });

        // 3. Restaurar tipos originales en tablas referenciadas
        Schema::table('aseguradoras', function (Blueprint $table) {
            $table->unsignedInteger('id_aseguradora')->change();
        });

        Schema::table('tomadores', function (Blueprint $table) {
            $table->unsignedInteger('id_tomador')->change();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedInteger('id_producto')->change();
        });

        Schema::table('ramos', function (Blueprint $table) {
            $table->unsignedInteger('id_ramo')->change();
        });

        Schema::table('frecuencias', function (Blueprint $table) {
            $table->unsignedInteger('id_frecuencia')->change();
        });

        Schema::table('consultores', function (Blueprint $table) {
            $table->unsignedInteger('id_consultor')->change();
        });

        Schema::table('gerentes', function (Blueprint $table) {
            $table->unsignedInteger('id_gerente')->change();
        });

        // 4. Restaurar claves foráneas originales
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->foreign('id_aseguradora')->references('id_aseguradora')->on('aseguradoras');
            $table->foreign('id_tomador')->references('id_tomador')->on('tomadores');
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            $table->foreign('id_ramo')->references('id_ramo')->on('ramos');
            $table->foreign('id_frecuencia')->references('id_frecuencia')->on('frecuencias');
            $table->foreign('id_consultor')->references('id_consultor')->on('consultores');
            $table->foreign('id_gerente')->references('id_gerente')->on('gerentes');
        });
    }
};
