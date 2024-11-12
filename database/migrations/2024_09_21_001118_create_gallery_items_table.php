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
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->foreignId('gallery_category_id')->constrained();
            $table->string('title', 250);
            $table->string('subtitle', 250)->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->text('link_url')->nullable();
            $table->boolean('show_button1')->nullable();
            $table->tinyInteger('button1_link_type')->nullable();
            $table->bigInteger('button1_link_page_id')->nullable();
            $table->string('button1_text', 100)->nullable();
            $table->tinyInteger('button1_link_open_type')->nullable();
            $table->boolean('show_button2')->nullable();
            $table->tinyInteger('button2_link_type')->nullable();
            $table->bigInteger('button2_link_page_id')->nullable();
            $table->string('button2_text', 100)->nullable();
            $table->tinyInteger('button2_link_open_type')->nullable();
            $table->boolean('show_button3')->nullable();
            $table->tinyInteger('button3_link_type')->nullable();
            $table->bigInteger('button3_link_page_id')->nullable();
            $table->string('button3_text', 100)->nullable();
            $table->tinyInteger('button3_link_open_type')->nullable();
            $table->boolean('visible');
            $table->bigInteger('sort_order');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
