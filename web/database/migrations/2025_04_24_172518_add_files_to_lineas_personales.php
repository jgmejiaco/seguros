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
            $table->string('file_cedula')->nullable()->after('fecha_cancelacion');
            $table->string('file_matricula')->nullable()->after('file_cedula');
            $table->string('file_asegurabilidad')->nullable()->after('file_matricula');
            $table->string('file_sarlaft')->nullable()->after('file_asegurabilidad');
            $table->string('file_caratula_poliza')->nullable()->after('file_sarlaft');
            $table->string('file_renovacion')->nullable()->after('file_caratula_poliza');
            $table->string('file_otros')->nullable()->after('file_renovacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_personales', function (Blueprint $table) {
            $table->dropColumn('file_cedula');
            $table->dropColumn('file_matricula');
            $table->dropColumn('file_asegurabilidad');
            $table->dropColumn('file_sarlaft');
            $table->dropColumn('file_caratula_poliza');
            $table->dropColumn('file_renovacion');
            $table->dropColumn('file_otros');
        });
    }
};
