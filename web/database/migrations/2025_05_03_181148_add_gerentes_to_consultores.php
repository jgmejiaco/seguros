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
        Schema::table('consultores', function (Blueprint $table) {
            $table->string('gerente_comercial')->nullable()->after('consultor');
            $table->string('lider_comercial')->nullable()->after('gerente_comercial');
            $table->string('equipo_informes')->nullable()->after('lider_comercial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultores', function (Blueprint $table) {
            $table->dropColumn('gerente_comercial');
            $table->dropColumn('lider_comercial');
            $table->dropColumn('equipo_informes');
        });
    }
};
