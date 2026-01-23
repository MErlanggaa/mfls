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
        Schema::create('daftar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('no_wa');
            $table->string('jenis_kelamin');
            $table->integer('tahun_lulus');
            $table->string('ttl');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('asal_sekolah');
            $table->string('no_sekolah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar');
    }
};
