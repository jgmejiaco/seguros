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
            $table->date('fecha_nacimiento')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->string('fecha_nacimiento')->change();
        });
    }
};
