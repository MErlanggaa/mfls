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
        Schema::table('soal', function (Blueprint $table) {
            $table->string('kunci_jawaban')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->enum('kunci_jawaban', ['a', 'b', 'c', 'd', 'e'])->nullable(false)->change();
        });
    }
};
