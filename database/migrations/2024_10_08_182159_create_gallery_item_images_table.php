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
        Schema::create('gallery_item_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_item_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('sort_order');
            $table->bigInteger('image_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_item_images');
    }
};
