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
            $table->string('identificacion_tomador')->nullable()->after('id_tomador');
            $table->string('tomador')->nullable()->after('identificacion_tomador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropColumn('identificacion_tomador');
            $table->dropColumn('tomador');
        });
    }
};
