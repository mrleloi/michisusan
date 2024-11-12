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
        Schema::table(
            'sites', function (Blueprint $table) {
                $table->string('seo_title_separator', 1)->nullable()->after('seo_title');
                $table->string('copyright', 200)->nullable()->after('seo_title_separator');
                $table->string('favicon_image', 255)->nullable()->after('copyright');
                $table->string('apple_touch_icon_image', 255)->nullable()->after('favicon_image');
                $table->integer('use_www')->nullable()->after('apple_touch_icon_image');
                $table->string('breadcrumb_top', 20)->nullable()->after('use_www');
                $table->boolean('noindex_nofollow')->nullable()->after('breadcrumb_top');
                $table->integer('show_link_cookie_policy')->nullable()->after('noindex_nofollow');
                $table->string('account', 30)->nullable()->after('show_link_cookie_policy');
                $table->string('password', 16)->nullable()->after('account');
                $table->text('robots_text')->nullable()->after('password');
                $table->text('exclude_ips')->nullable()->after('robots_text');
                $table->string('industry', 30)->nullable()->after('exclude_ips');
                $table->integer('header_layout')->nullable()->after('industry');
                $table->boolean('mv_overlay')->nullable()->after('header_layout');
                $table->boolean('header_scroll')->nullable()->after('mv_overlay');
                $table->integer('header_width')->nullable()->after('header_scroll');
                $table->integer('title_font')->nullable()->after('header_width');
                $table->integer('body_font')->nullable()->after('title_font');
                $table->integer('loading_animation')->nullable()->after('body_font');
                $table->string('main_image', 255)->nullable()->after('loading_animation');
                $table->integer('image_display_type')->nullable()->after('main_image');
                $table->boolean('image_popup')->nullable()->after('image_display_type');
                $table->integer('element_alignment')->nullable()->after('image_popup');
                $table->integer('element_fadein')->nullable()->after('element_alignment');
                $table->boolean('noimage_grayscale')->nullable()->after('element_fadein');
                $table->integer('footer_layout')->nullable()->after('noimage_grayscale');
                $table->integer('footer_width')->nullable()->after('footer_layout');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'sites', function (Blueprint $table) {
                $table->dropColumn([
                    'seo_title_separator', 'copyright', 'favicon_image', 'apple_touch_icon_image', 
                    'use_www', 'breadcrumb_top', 'noindex_nofollow', 'show_link_cookie_policy', 'account', 
                    'password', 'robots_text', 'exclude_ips', 'industry', 'header_layout', 'mv_overlay', 
                    'header_scroll', 'header_width', 'title_font', 'body_font', 'loading_animation', 
                    'main_image', 'image_display_type', 'image_popup', 'element_alignment', 'element_fadein', 
                    'noimage_grayscale', 'footer_layout', 'footer_width'
                ]);
            }
        );
    }
};
