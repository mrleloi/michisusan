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
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('directory', 30);
            $table->bigInteger('subnavigation_id')->nullable();
            $table->string('h1_text', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn(['directory', 'subnavigation_id', 'h1_text']);
        });
    }
};
