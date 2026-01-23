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
            $table->string('no_whatsapp')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->integer('tahun_lulus')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('telp_sekolah')->nullable();
            $table->string('nisn')->nullable()->change(); // Allow null temporarily if needed or just keep it
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['no_whatsapp', 'tgl_lahir', 'jenis_kelamin', 'tahun_lulus', 'provinsi', 'kabupaten', 'nama_sekolah', 'telp_sekolah']);
        });
    }
};
