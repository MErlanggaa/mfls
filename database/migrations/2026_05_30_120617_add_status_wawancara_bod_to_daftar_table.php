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
        Schema::table('daftar', function (Blueprint $table) {
            $table->enum('status_wawancara_bod', ['Layak', 'Tidak Layak'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar', function (Blueprint $table) {
            $table->dropColumn('status_wawancara_bod');
        });
    }
};
