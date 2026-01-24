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
        Schema::table('penilaian_mentor', function (Blueprint $table) {
            $table->decimal('nilai_kepemimpinan', 5, 2)->default(0);
            $table->decimal('nilai_kepribadian', 5, 2)->default(0);
            $table->decimal('nilai_keaktifan', 5, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_mentor', function (Blueprint $table) {
            $table->dropColumn(['nilai_kepemimpinan', 'nilai_kepribadian', 'nilai_keaktifan']);
        });
    }
};
