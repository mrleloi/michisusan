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
        Schema::create('font_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constraint();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->tinyInteger('status')->nullable()->comment('0: in-active, 1: active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('font_weights');
    }
};
