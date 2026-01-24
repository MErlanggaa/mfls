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
            $table->enum('status', ['menunggu', 'lulus', 'tidak_lulus'])->default('menunggu')->after('kode_referral');
            $table->decimal('rata_rata_nilai', 5, 2)->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar', function (Blueprint $table) {
            $table->dropColumn(['status', 'rata_rata_nilai']);
        });
    }
};
