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
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('table_name');  // 'pages', 'news_articles', 'blog_posts'
            $table->string('record_id');
            $table->string('page_title')->nullable();;
            $table->integer('status')->nullable(); // 1: created, 2: updated, 3: deleted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
