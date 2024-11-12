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
        Schema::create('side_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('top_banner1_link_url', 255)->nullable();
            $table->string('top_banner1_image', 255)->nullable();
            $table->string('top_banner1_alt', 255)->nullable();
            $table->string('top_banner2_link_url', 255)->nullable();
            $table->string('top_banner2_image', 255)->nullable();
            $table->string('top_banner2_alt', 255)->nullable();
            $table->string('top_banner3_link_url', 255)->nullable();
            $table->string('top_banner3_image', 255)->nullable();
            $table->string('top_banner3_alt', 255)->nullable();
            $table->string('top_banner4_link_url', 255)->nullable();
            $table->string('top_banner4_image', 255)->nullable();
            $table->string('top_banner4_alt', 255)->nullable();
            $table->string('top_banner5_link_url', 255)->nullable();
            $table->string('top_banner5_image', 255)->nullable();
            $table->string('top_banner5_alt', 255)->nullable();
            $table->string('top_banner6_link_url', 255)->nullable();
            $table->string('top_banner6_image', 255)->nullable();
            $table->string('top_banner6_alt', 255)->nullable();
            $table->string('top_banner7_link_url', 255)->nullable();
            $table->string('top_banner7_image', 255)->nullable();
            $table->string('top_banner7_alt', 255)->nullable();
            $table->string('top_banner8_link_url', 255)->nullable();
            $table->string('top_banner8_image', 255)->nullable();
            $table->string('top_banner8_alt', 255)->nullable();
            $table->string('bottom_banner1_link_url', 255)->nullable();
            $table->string('bottom_banner1_image', 255)->nullable();
            $table->string('bottom_banner1_alt', 255)->nullable();
            $table->string('bottom_banner2_link_url', 255)->nullable();
            $table->string('bottom_banner2_image', 255)->nullable();
            $table->string('bottom_banner2_alt', 255)->nullable();
            $table->string('bottom_banner3_link_url', 255)->nullable();
            $table->string('bottom_banner3_image', 255)->nullable();
            $table->string('bottom_banner3_alt', 255)->nullable();
            $table->string('bottom_banner4_link_url', 255)->nullable();
            $table->string('bottom_banner4_image', 255)->nullable();
            $table->string('bottom_banner4_alt', 255)->nullable();
            $table->string('bottom_banner5_link_url', 255)->nullable();
            $table->string('bottom_banner5_image', 255)->nullable();
            $table->string('bottom_banner5_alt', 255)->nullable();
            $table->string('bottom_banner6_link_url', 255)->nullable();
            $table->string('bottom_banner6_image', 255)->nullable();
            $table->string('bottom_banner6_alt', 255)->nullable();
            $table->string('bottom_banner7_link_url', 255)->nullable();
            $table->string('bottom_banner7_image', 255)->nullable();
            $table->string('bottom_banner7_alt', 255)->nullable();
            $table->string('bottom_banner8_link_url', 255)->nullable();
            $table->string('bottom_banner8_image', 255)->nullable();
            $table->string('bottom_banner8_alt', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('side_banners');
    }
};
