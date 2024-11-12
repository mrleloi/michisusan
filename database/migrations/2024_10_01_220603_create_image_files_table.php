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
        Schema::create('image_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constraint();
            $table->foreignId('image_file_category_id')->nullable()->constrained();
            $table->string('filename', 100);
            $table->string('thumbnail_filename', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_files');
    }
};
