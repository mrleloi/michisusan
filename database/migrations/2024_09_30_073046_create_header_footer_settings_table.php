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
        Schema::create('header_footer_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('tel1', 31)->nullable();
            $table->string('tel1_remarks', 255)->nullable();
            $table->string('tel2', 31)->nullable();
            $table->string('tel2_remarks', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('business_hours', 255)->nullable();
            $table->string('show_header_logo_image', 255)->nullable();
            $table->boolean('show_header_translation')->default(false);
            $table->boolean('show_header_tel1')->default(false);
            $table->boolean('show_header_tel2')->default(false);
            $table->boolean('show_header_address')->default(false);
            $table->boolean('show_header_business_hours')->default(false);
            $table->boolean('show_header_button')->default(false);
            $table->boolean('show_pc_header_sns_link')->default(false);
            $table->string('header_button1_link_url', 255)->nullable();
            $table->string('header_button1_alt', 255)->nullable();
            $table->integer('header_button1_link_open_type')->length(1)->nullable();
            $table->string('header_button2_link_url', 255)->nullable();
            $table->string('header_button2_alt', 255)->nullable();
            $table->integer('header_button2_link_open_type')->length(1)->nullable();
            $table->integer('header_default_position')->length(1)->nullable();
            $table->string('header_menu_text_color', 20)->nullable();
            $table->string('header_menu_text_font', 128)->nullable();
            $table->boolean('show_bottom_navi')->default(false);
            $table->char('header_menu_text_separator', 1)->default(false);
            $table->integer('header_menu_hover_animation')->length(1)->nullable();
            $table->string('header_menu_hover_animation_text_color', 20)->nullable();
            $table->string('header_menu_hover_animation_bg_color', 20)->nullable();
            $table->boolean('show_header_menu_sp')->default(false);
            $table->string('sp_header_menu1_link_url', 255)->nullable();
            $table->string('sp_header_menu1_alt', 31)->nullable();
            $table->string('sp_header_menu2_link_url', 255)->nullable();
            $table->string('sp_header_menu2_alt', 31)->nullable();
            $table->string('sp_header_menu3_link_url', 255)->nullable();
            $table->string('sp_header_menu3_alt', 31)->nullable();
            $table->string('sp_header_menu4_link_url', 255)->nullable();
            $table->string('sp_header_menu4_alt', 31)->nullable();
            $table->string('sticky_footer_logo_image', 255)->nullable();
            $table->boolean('show_sticky_footer')->default(false);
            $table->boolean('show_sticky_footer_tel1')->default(false);
            $table->boolean('show_sticky_footer_tel2')->default(false);
            $table->boolean('show_sticky_footer_business_hours')->default(false);
            $table->boolean('show_sticky_footer_button')->default(false);
            $table->string('sticky_footer_button1_link_url', 255)->nullable();
            $table->string('sticky_footer_button1_alt', 255)->nullable();
            $table->integer('sticky_footer_button1_link_open_type')->length(1)->nullable();
            $table->string('sticky_footer_button2_link_url', 255)->nullable();
            $table->string('sticky_footer_button2_alt', 255)->nullable();
            $table->integer('sticky_footer_button2_link_open_type')->length(1)->nullable();
            $table->boolean('ellipsis_sticky_footer_navi_item')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_footer_settings');
    }
};
