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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('name', 250);
            $table->string('price', 20)->nullable();
            $table->boolean('append_wave_dash')->nullable();
            $table->tinyInteger('tax_type')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('image1_id')->nullable();
            $table->bigInteger('image2_id')->nullable();
            $table->bigInteger('image3_id')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
};
