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
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('show_tag', 80)->nullable();
            $table->integer('show_common_footer')->nullable();
            $table->string('account', 30)->nullable();
            $table->string('password', 30)->nullable();
            $table->boolean('show_header')->default(false);
            $table->boolean('show_header_logo')->default(false);
            $table->boolean('show_header_navimenu')->default(false);
            $table->boolean('show_header_mv')->default(false);
            $table->boolean('show_footer')->default(false);
            $table->boolean('show_footer_logo')->default(false);
            $table->boolean('show_footer_navimenu')->default(false);
            $table->boolean('show_footer_sns')->default(false);
            $table->longText('custom_css')->nullable();
            $table->longText('custom_javascript')->nullable();
            $table->longText('custom_head_tag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn([
                'show_tag',
                'show_common_footer',
                'account',
                'password',
                'eye_catch',
                'show_header',
                'show_header_logo',
                'show_header_navimenu',
                'show_header_mv',
                'show_footer',
                'show_footer_logo',
                'show_footer_navimenu',
                'show_footer_sns',
                'subnavagation_id',
                'custom_css',
                'custom_javascript',
                'custom_head_tag'
            ]);
        });
    }
};
