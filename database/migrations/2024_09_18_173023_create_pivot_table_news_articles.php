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
        Schema::create('news_article_sns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_article_id')->constrained()->onDelete('cascade');
            $table->foreignId('news_sns_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('news_article_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_article_id')->constrained()->onDelete('cascade');
            $table->foreignId('news_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_article_sns');
        Schema::dropIfExists('news_article_category');
    }
};
