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
        Schema::table('berkas', function (Blueprint $table) {
            $table->text('rapor1')->change();
            $table->text('rapor2')->change();
            $table->text('rapor3')->change();
            $table->text('rapor4')->change();
            $table->text('rapor5')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->string('rapor1')->change();
            $table->string('rapor2')->change();
            $table->string('rapor3')->change();
            $table->string('rapor4')->change();
            $table->string('rapor5')->change();
        });
    }
};
