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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('title', 35);
            $table->tinyInteger('with_seo_title')->default(0);
            $table->string('description', 250)->nullable();
            $table->string('h1_text', 20)->nullable();
            $table->string('directory', 30);
            $table->string('keywords', 80)->nullable();
            $table->string('show_tag', 80)->nullable();
            $table->string('account', 30)->nullable();
            $table->string('password', 30)->nullable();
            $table->string('eye_catch', 255)->nullable();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->boolean('show_top_navi')->default(false);
            $table->boolean('show_side_navi')->default(false);
            $table->boolean('show_bottom_navi')->default(false);
            $table->boolean('show_category')->default(false);
            $table->boolean('show_related_page')->default(false);
            $table->boolean('show_related_tag')->default(false);
            $table->boolean('show_sitemap')->default(false);
            $table->boolean('show_common_side_navi')->default(false);
            $table->integer('show_common_footer')->nullable();
            $table->boolean('show_seo_analysis')->default(false);
            $table->boolean('show_header')->default(false);
            $table->boolean('show_header_logo')->default(false);
            $table->boolean('show_header_navimenu')->default(false);
            $table->boolean('show_header_mv')->default(false);
            $table->boolean('show_footer')->default(false);
            $table->boolean('show_footer_logo')->default(false);
            $table->boolean('show_footer_navimenu')->default(false);
            $table->boolean('show_footer_sns')->default(false);
            $table->bigInteger('subnavigation_id')->nullable();
            $table->longText('custom_css')->nullable();
            $table->longText('custom_javascript')->nullable();
            $table->longText('custom_head_tag')->nullable();
            $table->text('content')->nullable();
            $table->integer('publish_status')->default(1);
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('pages', function (Blueprint $table) {
        //     $table->dropColumn([
        //         'site_id',
        //         'title',
        //         'with_seo_title',
        //         'description',
        //         'h1_text',
        //         'navigation_name',
        //         'directory',
        //         'keywords',
        //         'show_tag',
        //         'show_common_footer',
        //         'account',
        //         'password',
        //         'eye_catch',
        //         'page_id',
        //         'show_top_navi',
        //         'show_side_navi',
        //         'show_bottom_navi',
        //         'show_category',
        //         'show_related_page',
        //         'show_related_tag',
        //         'show_sitemap',
        //         'show_common_side_navi',
        //         'show_seo_analysis',
        //         'show_header',
        //         'show_header_logo',
        //         'show_header_navimenu',
        //         'show_header_mv',
        //         'show_footer',
        //         'show_footer_logo',
        //         'show_footer_navimenu',
        //         'show_footer_sns',
        //         'subnavagation_id',
        //         'custom_css',
        //         'custom_javascript',
        //         'custom_head_tag',
        //         'content',
        //         'publish_status',
        //         'published_at',
        //     ]);
        // });
    }
};
