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
        Schema::create('keputusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('akademik_id')->constrained('akun')->onDelete('cascade');
            $table->enum('status', ['lolos', 'tidak_lolos']);
            $table->enum('persentase_beasiswa', ['25', '50', '75', '100']);
            $table->boolean('undangan_kampus')->default(false);
            $table->boolean('status_pengumuman')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keputusan');
    }
};
