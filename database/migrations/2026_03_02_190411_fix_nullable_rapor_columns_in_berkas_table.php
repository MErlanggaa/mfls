<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Jadikan semua kolom rapor dan berkas lainnya nullable,
     * karena migration sebelumnya mengubah tipe ke text tanpa nullable().
     */
    public function up(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->text('rapor1')->nullable()->change();
            $table->text('rapor2')->nullable()->change();
            $table->text('rapor3')->nullable()->change();
            $table->text('rapor4')->nullable()->change();
            $table->text('rapor5')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->text('rapor1')->nullable(false)->change();
            $table->text('rapor2')->nullable(false)->change();
            $table->text('rapor3')->nullable(false)->change();
            $table->text('rapor4')->nullable(false)->change();
            $table->text('rapor5')->nullable(false)->change();
        });
    }
};
