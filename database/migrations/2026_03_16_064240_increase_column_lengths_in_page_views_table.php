```php
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
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('url', 2048)->change();
            $table->string('user_agent', 255)->nullable()->change();
            $table->string('referer', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('url', 255)->change();
            $table->string('user_agent', 255)->nullable()->change();
            $table->string('referer', 255)->nullable()->change();
        });
    }
};
