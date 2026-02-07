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
        Schema::table('peserta', function (Blueprint $table) {
            $table->string('pilihan_prodi')->nullable()->after('nama');
        });

        Schema::table('berkas', function (Blueprint $table) {
            $table->string('surat_buta_warna')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn('pilihan_prodi');
        });

        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn('surat_buta_warna');
        });
    }
};
