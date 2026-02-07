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
        Schema::create('penilaian_akademik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('penilai_id')->constrained('akun')->onDelete('cascade');
            
            // Penilaian Wawancara Prodi & Kemahasiswaan
            $table->integer('nilai_wawancara')->default(0);
            
            // Penilaian Motivasi & Komitmen
            $table->integer('nilai_motivasi')->default(0);
            
            // Prestasi Akademik/Non-Akademik
            $table->integer('nilai_prestasi')->default(0);
            
            // Kondisi Sosial & Ekonomi
            $table->integer('nilai_ekonomi')->default(0);
            
            // Kepribadian & Integritas
            $table->integer('nilai_kepribadian')->default(0);
            
            // Potensi Kontribusi & Leadership
            $table->integer('nilai_leadership')->default(0);
            
            $table->integer('total_nilai')->default(0);
            $table->text('catatan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_akademik');
    }
};
