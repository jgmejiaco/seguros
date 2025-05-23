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
            $table->unsignedBigInteger('id_medio_pago')->nullable()->after('fecha_cancelacion');
            $table->unsignedBigInteger('id_financiera')->nullable()->after('id_medio_pago');

            $table->foreign('id_medio_pago')->references('id_medio_pago')->on('medios_pago')->onDelete('set null');
            $table->foreign('id_financiera')->references('id_financiera')->on('financieras')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_personales', function (Blueprint $table) {
            // Primero se eliminan las foreign keys
            $table->dropForeign(['id_medio_pago']);
            $table->dropForeign(['id_financiera']);

            // Luego las columnas
            $table->dropColumn(['id_medio_pago', 'id_financiera']);
        });
    }
};
