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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre_usuario')->nullable();
            $table->string('apellido_usuario')->nullable();
            $table->string('correo')->nullable();
            $table->integer('id_estado')->nullable()->unsigned();
            $table->foreignId('id_rol')->nullable()->constrained('roles');
            $table->string('usuario')->nullable();
            $table->string('clave')->nullable();
            $table->integer('clave_fallas')->nullable()->unsigned();
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
