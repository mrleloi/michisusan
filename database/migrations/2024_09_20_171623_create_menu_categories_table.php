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
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites');
            $table->string('name', 250);
            $table->string('alias', 250)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('image1_id')->nullable();
            $table->bigInteger('image2_id')->nullable();
            $table->bigInteger('image3_id')->nullable();
            $table->bigInteger('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_categories');
    }
};
