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
        Schema::table('news_settings', function (Blueprint $table) {
            $table->text('top_signature')->nullable();
            $table->text('bottom_signature')->nullable();
            $table->bigInteger('subnavigation_id')->nullable();
            $table->string('account', 30)->nullable();
            $table->string('password', 30)->nullable();
            $table->longText('custom_head_tag')->nullable();
            $table->string('top_title', 50)->nullable();
            $table->string('top_subtitle', 50)->nullable();
            $table->string('top_text', 50)->nullable();
            $table->integer('top_title_position')->nullable();
            $table->integer('top_text_position')->nullable();
            $table->string('bottom_title', 50)->nullable();
            $table->string('bottom_subtitle', 50)->nullable();
            $table->string('bottom_text', 50)->nullable();
            $table->integer('bottom_title_position')->nullable();
            $table->integer('bottom_text_position')->nullable();
            $table->string('introduction_title', 50)->nullable();
            $table->string('introduction_image', 255)->nullable();
            $table->text('introduction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_settings', function (Blueprint $table) {
            $table->dropColumn([
                'top_signature',
                'bottom_signature',
                'subnavigation_id',
                'account',
                'password',
                'custom_head_tag',
                'top_title',
                'top_subtitle',
                'top_text',
                'top_title_position',
                'top_text_position',
                'bottom_title',
                'bottom_subtitle',
                'bottom_text',
                'bottom_title_position',
                'bottom_text_position',
                'introduction_title',
                'introduction_image',
                'introduction'
            ]);
        });
    }
};
