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
        Schema::table('aseguradoras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('aseguradora');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('consultores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('consultor');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('frecuencias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('frecuencia');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('gerentes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('gerente');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('producto');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('ramos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('ramo');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });

        Schema::table('tomadores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable()->default(1)->after('tomador');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aseguradoras', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('consultores', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('frecuencias', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('gerentes', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('ramos', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });

        Schema::table('tomadores', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });
    }
};
