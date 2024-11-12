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
        Schema::create('subnavigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('name');
            $table->bigInteger('start_page_id')->nullable();
            $table->string('loading_image')->nullable();
            $table->string('common_tel_1')->nullable();
            $table->string('common_tel_1_header_note')->nullable();
            $table->string('common_tel_1_footer_note')->nullable();
            $table->string('common_tel_2')->nullable();
            $table->string('common_tel_2_header_note')->nullable();
            $table->string('common_tel_2_footer_note')->nullable();
            $table->string('common_address')->nullable();
            $table->string('common_hour')->nullable();
            $table->string('header_logo_image')->nullable();
            $table->boolean('show_h_translation')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_h_tel_1')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_h_tel_2')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_h_address')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_h_hour')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_h_button')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_header_sns_on_pc')->nullable()->comment('1: Show, 0: Hide');
            $table->tinyInteger('header_btn_1_link_type')->default(1)->comment('1: Select from list, 2: Input');
            $table->bigInteger('header_btn_1_link01')->nullable();
            $table->string('header_btn_1_link02')->nullable();
            $table->string('header_btn_1_text')->nullable();
            $table->tinyInteger('header_btn_1_link_target')->default(1)->comment('1: open in the same window, 2: open in a separate window');
            $table->tinyInteger('header_btn_2_link_type')->default(1)->comment('1: Select from list, 2: Input');
            $table->bigInteger('header_btn_2_link01')->nullable();
            $table->string('header_btn_2_link02')->nullable();
            $table->string('header_btn_2_text')->nullable();
            $table->tinyInteger('header_btn_2_link_target')->default(1)->comment('1: open in the same window, 2: open in a separate window');
            $table->tinyInteger('header_text_align_flag')->default(1)->comment('1: Align left, 2: Align center, 3: Align right');
            $table->string('header_menu_text_color')->nullable();
            $table->string('header_menu_title_font')->nullable();
            $table->string('header_menu_body_font')->nullable();
            $table->string('header_menu_font_weight')->nullable();
            $table->string('header_menu_divider')->nullable();
            $table->string('header_menu_hover_animation')->nullable();
            $table->string('header_menu_hover_text_color')->nullable();
            $table->string('header_menu_hover_line_color')->nullable();
            $table->boolean('show_smartphone_menus')->nullable()->comment('1: Show, 0: Hide');
            $table->string('footer_logo_image')->nullable();
            $table->boolean('show_f_translation')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_f_tel_1')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_f_tel_2')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_f_address')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('show_f_hour')->nullable()->comment('1: Show, 0: Hide');
            $table->boolean('footer_btn_1_link_type')->default(1)->comment('1: Select from list, 2: Input');
            $table->bigInteger('footer_btn_1_link01')->nullable();
            $table->string('footer_btn_1_link02')->nullable();
            $table->string('footer_btn_1_text')->nullable();
            $table->tinyInteger('footer_btn_1_link_target')->default(1)->comment('1: Align left, 2: Align center, 3: Align right');
            $table->boolean('footer_btn_2_link_type')->default(1)->comment('1: Select from list, 2: Input');
            $table->string('footer_btn_2_link01')->nullable();
            $table->string('footer_btn_2_link02')->nullable();
            $table->string('footer_btn_2_text')->nullable();
            $table->tinyInteger('footer_btn_2_link_target')->default(1)->comment('1: open in the same window, 2: open in a separate window');
            $table->tinyInteger('footer_text_align_flag')->default(1)->comment('1: Align left, 2: Align center, 3: Align right');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subnavigations');
    }
};
