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
            // Motivasi & Komitmen (4 Questions)
            $table->float('wawancara_motivasi_q1')->nullable()->after('wawancara_motivasi');
            $table->float('wawancara_motivasi_q2')->nullable()->after('wawancara_motivasi_q1');
            $table->float('wawancara_motivasi_q3')->nullable()->after('wawancara_motivasi_q2');
            $table->float('wawancara_motivasi_q4')->nullable()->after('wawancara_motivasi_q3');

            // Prestasi Akademik (4 Questions)
            $table->float('wawancara_prestasi_q1')->nullable()->after('wawancara_prestasi');
            $table->float('wawancara_prestasi_q2')->nullable()->after('wawancara_prestasi_q1');
            $table->float('wawancara_prestasi_q3')->nullable()->after('wawancara_prestasi_q2');
            $table->float('wawancara_prestasi_q4')->nullable()->after('wawancara_prestasi_q3');

            // Karakter & Integritas (4 Questions)
            $table->float('wawancara_karakter_q1')->nullable()->after('wawancara_karakter');
            $table->float('wawancara_karakter_q2')->nullable()->after('wawancara_karakter_q1');
            $table->float('wawancara_karakter_q3')->nullable()->after('wawancara_karakter_q2');
            $table->float('wawancara_karakter_q4')->nullable()->after('wawancara_karakter_q3');

            // Kontribusi & Kepemimpinan (4 Questions)
            $table->float('wawancara_kontribusi_q1')->nullable()->after('wawancara_kontribusi');
            $table->float('wawancara_kontribusi_q2')->nullable()->after('wawancara_kontribusi_q1');
            $table->float('wawancara_kontribusi_q3')->nullable()->after('wawancara_kontribusi_q2');
            $table->float('wawancara_kontribusi_q4')->nullable()->after('wawancara_kontribusi_q3');

            // Kemampuan Komunikasi (4 Questions)
            $table->float('wawancara_komunikasi_q1')->nullable()->after('wawancara_komunikasi');
            $table->float('wawancara_komunikasi_q2')->nullable()->after('wawancara_komunikasi_q1');
            $table->float('wawancara_komunikasi_q3')->nullable()->after('wawancara_komunikasi_q2');
            $table->float('wawancara_komunikasi_q4')->nullable()->after('wawancara_komunikasi_q3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_akademiks', function (Blueprint $table) {
            $table->dropColumn([
                'wawancara_motivasi_q1', 'wawancara_motivasi_q2', 'wawancara_motivasi_q3', 'wawancara_motivasi_q4',
                'wawancara_prestasi_q1', 'wawancara_prestasi_q2', 'wawancara_prestasi_q3', 'wawancara_prestasi_q4',
                'wawancara_karakter_q1', 'wawancara_karakter_q2', 'wawancara_karakter_q3', 'wawancara_karakter_q4',
                'wawancara_kontribusi_q1', 'wawancara_kontribusi_q2', 'wawancara_kontribusi_q3', 'wawancara_kontribusi_q4',
                'wawancara_komunikasi_q1', 'wawancara_komunikasi_q2', 'wawancara_komunikasi_q3', 'wawancara_komunikasi_q4',
            ]);
        });
    }
};
