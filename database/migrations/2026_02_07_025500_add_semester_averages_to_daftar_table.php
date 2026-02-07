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
            $table->decimal('avg_semester_1', 5, 2)->default(0)->after('rata_rata_nilai');
            $table->decimal('avg_semester_2', 5, 2)->default(0)->after('avg_semester_1');
            $table->decimal('avg_semester_3', 5, 2)->default(0)->after('avg_semester_2');
            $table->decimal('avg_semester_4', 5, 2)->default(0)->after('avg_semester_3');
            $table->decimal('avg_semester_5', 5, 2)->default(0)->after('avg_semester_4');
            $table->decimal('avg_semester_6', 5, 2)->default(0)->after('avg_semester_5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar', function (Blueprint $table) {
            $table->dropColumn([
                'avg_semester_1',
                'avg_semester_2',
                'avg_semester_3',
                'avg_semester_4',
                'avg_semester_5',
                'avg_semester_6'
            ]);
        });
    }
};
