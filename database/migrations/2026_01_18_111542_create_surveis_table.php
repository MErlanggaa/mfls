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
        Schema::create('survei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->string('info_sumber');
            $table->text('motivasi');
            $table->boolean('bersedia_informasi_lain')->default(false);
            $table->boolean('daftar_beasiswa_lain')->default(false);
            $table->boolean('daftar_univ_lain')->default(false);
            $table->boolean('mengikuti_osis')->default(false);
            $table->boolean('mengikuti_forum_osis')->default(false);
            $table->boolean('anggota_forum_anak')->default(false);
            $table->boolean('sudah_diterima_kampus_lain')->default(false);
            $table->boolean('sudah_daftar_diterima_telkom')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei');
    }
};
