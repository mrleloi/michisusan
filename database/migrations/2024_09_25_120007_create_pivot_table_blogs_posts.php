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
        Schema::create('blogs_post_sns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blogs_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('blogs_sns_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('blogs_post_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blogs_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('blogs_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_post_sns');
        Schema::dropIfExists('blogs_post_category');
    }
};
