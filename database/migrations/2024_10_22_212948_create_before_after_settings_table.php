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
        Schema::create('before_after_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('page_title', 35)->nullable();
            $table->string('description', 250)->nullable();
            $table->string('h1_text', 35)->nullable();
            $table->string('navi_display_name', 100)->nullable();
            $table->string('directory_name', 250);
            $table->string('keywords', 250)->nullable();
            $table->json('navi_menu')->nullable();
            $table->json('footer')->nullable();
            $table->bigInteger('header_image_id')->nullable();
            $table->boolean('show_header_image')->nullable();
            $table->bigInteger('list_design')->nullable();
            $table->integer('number_of_items')->nullable();
            $table->integer('number_of_articles')->nullable();
            $table->tinyInteger('category_navi_type')->nullable();
            $table->string('show_all_name', 250)->nullable();
            $table->tinyInteger('article_order')->nullable();
            $table->integer('subnavigation')->nullable();
            $table->string('access_limitation_account', 30)->nullable();
            $table->string('access_limitation_password', 16)->nullable();
            $table->text('original_head_tag')->nullable();
            $table->string('above_title', 250)->nullable();
            $table->string('above_subtitle', 250)->nullable();
            $table->text('above_text')->nullable();
            $table->tinyInteger('above_titles_position')->nullable();
            $table->tinyInteger('above_text_position')->nullable();
            $table->string('below_title', 250)->nullable();
            $table->string('below_subtitle', 250)->nullable();
            $table->text('below_text')->nullable();
            $table->tinyInteger('below_titles_position')->nullable();
            $table->tinyInteger('below_text_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('before_after_settings');
    }
};
