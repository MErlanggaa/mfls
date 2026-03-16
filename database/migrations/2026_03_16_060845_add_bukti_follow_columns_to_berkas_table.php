<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->string('bukti_follow_ig_beasiswamncu')->nullable();
            $table->string('bukti_follow_ig_mncu')->nullable();
            $table->string('bukti_follow_tiktok_beasiswamncu')->nullable();
            $table->string('bukti_follow_tiktok_mncu')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn([
                'bukti_follow_ig_beasiswamncu',
                'bukti_follow_ig_mncu',
                'bukti_follow_tiktok_beasiswamncu',
                'bukti_follow_tiktok_mncu',
            ]);
        });
    }
};
