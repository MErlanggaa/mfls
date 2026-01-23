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
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->string('rapor1')->nullable();
            $table->string('rapor2')->nullable();
            $table->string('rapor3')->nullable();
            $table->string('rapor4')->nullable();
            $table->string('rapor5')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('surat_rekom')->nullable();
            $table->string('personal_statement')->nullable();
            $table->string('motivasi_video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
