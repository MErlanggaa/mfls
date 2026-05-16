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
            $table->text('opsi_e')->nullable()->after('opsi_d_image');
            $table->string('opsi_e_image')->nullable()->after('opsi_e');
            $table->string('kategori')->nullable()->after('opsi_e_image'); // For grouping (e.g., Self Awareness)
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropColumn(['opsi_e', 'opsi_e_image', 'kategori']);
        });
    }
};
