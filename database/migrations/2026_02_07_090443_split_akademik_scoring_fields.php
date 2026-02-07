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
        Schema::rename('penilaian_akademik', 'penilaian_akademiks');

        Schema::table('penilaian_akademiks', function (Blueprint $table) {
            $table->dropColumn(['nilai_wawancara', 'nilai_motivasi', 'nilai_prestasi', 'nilai_ekonomi', 'nilai_kepribadian', 'nilai_leadership', 'total_nilai']);
            
            // Penilaian Dosen (5 Point)
            $table->float('dosen_kompetensi')->nullable();
            $table->float('dosen_motivasi')->nullable();
            $table->float('dosen_wawasan')->nullable();
            $table->float('dosen_karir')->nullable();
            $table->float('dosen_integritas')->nullable();
            $table->float('total_dosen')->nullable();

            // Penilaian Kemahasiswaan (5 Point)
            $table->float('mhs_leadership')->nullable();
            $table->float('mhs_organisasi')->nullable();
            $table->float('mhs_etika')->nullable();
            $table->float('mhs_adaptasi')->nullable();
            $table->float('mhs_komitmen')->nullable();
            $table->float('total_mhs')->nullable();

            // Hasil Akhir
            $table->float('total_akhir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('penilaian_akademiks', function (Blueprint $table) {
            $table->dropColumn([
                'dosen_kompetensi', 'dosen_motivasi', 'dosen_wawasan', 'dosen_karir', 'dosen_integritas', 'total_dosen',
                'mhs_leadership', 'mhs_organisasi', 'mhs_etika', 'mhs_adaptasi', 'mhs_komitmen', 'total_mhs',
                'total_akhir'
            ]);
            $table->float('nilai_wawancara')->nullable();
            $table->float('nilai_motivasi')->nullable();
            $table->float('nilai_prestasi')->nullable();
            $table->float('nilai_ekonomi')->nullable();
            $table->float('nilai_kepribadian')->nullable();
            $table->float('nilai_leadership')->nullable();
            $table->float('total_nilai')->nullable();
        });

        Schema::rename('penilaian_akademiks', 'penilaian_akademik');
    }
};
