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
        Schema::create('before_after_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->foreignId('before_after_category_id')->constrained();
            $table->string('title', 250);
            $table->text('content')->nullable();
            $table->bigInteger('before_image_id');
            $table->bigInteger('after_image_id');            
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
        Schema::dropIfExists('before_after_items');
    }
};
