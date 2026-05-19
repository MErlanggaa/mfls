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
        Schema::table('penilaian_akademiks', function (Blueprint $table) {
            $table->string('rekomendasi_kelas')->nullable();
            $table->string('rekomendasi_prodi_1')->nullable();
            $table->string('rekomendasi_prodi_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_akademiks', function (Blueprint $table) {
            $table->dropColumn(['rekomendasi_kelas', 'rekomendasi_prodi_1', 'rekomendasi_prodi_2']);
        });
    }
};
