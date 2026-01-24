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
        Schema::table('survei', function (Blueprint $table) {
            $table->renameColumn('sudah_daftar_diterima_telkom', 'sudah_daftar_diterima_mncuniversity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survei', function (Blueprint $table) {
            $table->renameColumn('sudah_daftar_diterima_mncuniversity', 'sudah_daftar_diterima_telkom');
        });
    }
};
