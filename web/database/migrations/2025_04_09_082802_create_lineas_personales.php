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
        Schema::create('lineas_personales', function (Blueprint $table) {
            $table->increments('id_lineas_personal');
            $table->date('fecha_radicado')->nullable();
            $table->unsignedInteger('id_aseguradora')->nullable();
            $table->string('poliza_asistente')->nullable();
            $table->unsignedInteger('id_tomador')->nullable();
            $table->unsignedInteger('id_producto')->nullable();
            $table->unsignedInteger('id_ramo')->nullable();
            $table->string('prima_anualizada')->nullable();
            $table->unsignedInteger('id_frecuencia')->nullable();
            $table->unsignedInteger('id_proceso')->nullable();
            $table->unsignedInteger('id_estado_inicial')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->unsignedInteger('id_consultor')->nullable();
            $table->unsignedInteger('id_gerente')->nullable();
            $table->unsignedInteger('id_estado_poliza')->nullable();
            $table->date('fecha_cancelacion')->nullable();
            $table->unsignedInteger('id_usuario')->nullable();

            $table->timestamps();
            $table->softdeletes();

            $table->foreign('id_aseguradora')->references('id_aseguradora')->on('aseguradoras');
            $table->foreign('id_tomador')->references('id_tomador')->on('tomadores');
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            $table->foreign('id_ramo')->references('id_ramo')->on('ramos');
            $table->foreign('id_frecuencia')->references('id_frecuencia')->on('frecuencias');
            $table->foreign('id_proceso')->references('id_estado')->on('estados');
            $table->foreign('id_estado_inicial')->references('id_estado')->on('estados');
            $table->foreign('id_consultor')->references('id_consultor')->on('consultores');
            $table->foreign('id_gerente')->references('id_gerente')->on('gerentes');
            $table->foreign('id_estado_poliza')->references('id_estado')->on('estados');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas_personales');
    }
};
