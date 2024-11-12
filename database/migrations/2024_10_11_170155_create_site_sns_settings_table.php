<?php

use App\Models\SiteSnsSetting;
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
        Schema::create('site_sns_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id');
            $table->integer('icon_design_type')->default(SiteSnsSetting::ICON_DESIGN_TYPE_ROUND);

            $table->string('line_url', 255)->nullable();
            $table->boolean('line_show_following_part')->default(true)->nullable();
            $table->boolean('line_show_pc_header')->default(true)->nullable();
            $table->boolean('line_show_sp_header')->default(true)->nullable();

            $table->string('instagram_url', 255)->nullable();
            $table->boolean('instagram_show_following_part')->default(true)->nullable();
            $table->boolean('instagram_show_pc_header')->default(true)->nullable();
            $table->boolean('instagram_show_sp_header')->default(true)->nullable();

            $table->string('tiktok_url', 255)->nullable();
            $table->boolean('tiktok_show_following_part')->default(true)->nullable();
            $table->boolean('tiktok_show_pc_header')->default(true)->nullable();
            $table->boolean('tiktok_show_sp_header')->default(true)->nullable();

            $table->string('youtube_url', 255)->nullable();
            $table->boolean('youtube_show_following_part')->default(true)->nullable();
            $table->boolean('youtube_show_pc_header')->default(true)->nullable();
            $table->boolean('youtube_show_sp_header')->default(true)->nullable();

            $table->string('facebook_url', 255)->nullable();
            $table->boolean('facebook_show_following_part')->default(true)->nullable();
            $table->boolean('facebook_show_pc_header')->default(true)->nullable();
            $table->boolean('facebook_show_sp_header')->default(true)->nullable();

            $table->string('twitter_url', 255)->nullable();
            $table->boolean('twitter_show_following_part')->default(true)->nullable();
            $table->boolean('twitter_show_pc_header')->default(true)->nullable();
            $table->boolean('twitter_show_sp_header')->default(true)->nullable();

            $table->string('threads_url', 255)->nullable();
            $table->boolean('threads_show_following_part')->default(true)->nullable();
            $table->boolean('threads_show_pc_header')->default(true)->nullable();
            $table->boolean('threads_show_sp_header')->default(true)->nullable();

            $table->string('ameblo_url', 255)->nullable();
            $table->boolean('ameblo_show_following_part')->default(true)->nullable();
            $table->boolean('ameblo_show_pc_header')->default(true)->nullable();
            $table->boolean('ameblo_show_sp_header')->default(true)->nullable();

            $table->string('other1_url', 255)->nullable();
            $table->boolean('other1_show_following_part')->default(true)->nullable();
            $table->boolean('other1_show_pc_header')->default(true)->nullable();
            $table->boolean('other1_show_sp_header')->default(true)->nullable();
            $table->string('other1_image', 255)->nullable();

            $table->string('other2_url', 255)->nullable();
            $table->boolean('other2_show_following_part')->default(true)->nullable();
            $table->boolean('other2_show_pc_header')->default(true)->nullable();
            $table->boolean('other2_show_sp_header')->default(true)->nullable();
            $table->string('other2_image', 255)->nullable();

            $table->string('other3_url', 255)->nullable();
            $table->boolean('other3_show_following_part')->default(true)->nullable();
            $table->boolean('other3_show_pc_header')->default(true)->nullable();
            $table->boolean('other3_show_sp_header')->default(true)->nullable();
            $table->string('other3_image', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_sns_settings');
    }
};
