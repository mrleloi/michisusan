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
        Schema::create('subnavigation_smartphone_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constraint();
            $table->foreignId('subnavigation_id')->constrained();
            $table->string('menu_key')->nullable();
            $table->tinyInteger('link_type')->default(1)->comment('1: Select from list, 2: Input');
            $table->bigInteger('link01')->nullable();
            $table->string('link02')->nullable();
            $table->string('url')->nullable();
            $table->string('media')->nullable();
            $table->string('text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subnavigation_smartphone_menus');
    }
};
