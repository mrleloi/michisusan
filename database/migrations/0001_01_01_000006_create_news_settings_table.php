<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start : create news_settings table
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
        Schema::create('news_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->foreignId('article_id')->constrained('news_articles')->onDelete('cascade');
            $table->string('name', 255);
            $table->tinyInteger('with_seo_title')->default(0);
            $table->string('directory', 30);
            $table->string('page_title', 30)->nullable();
            $table->string('description', 120)->nullable();
            $table->string('h1_text', 20)->nullable();
            $table->string('keywords', 120)->nullable();
            $table->tinyInteger('show_in_header_navimenu')->default(1);
            $table->tinyInteger('show_in_footer_navimenu')->default(1);
            $table->tinyInteger('show_in_site_map')->default(1);
            $table->tinyInteger('show_sns')->default(1);
            $table->tinyInteger('show_footer_index')->default(1);
            $table->tinyInteger('show_footer_articles')->default(1);
            $table->string('heading_image', 255)->nullable();
            $table->tinyInteger('show_heading_image')->default(1);
            $table->integer('design_type')->nullable();
            $table->integer('per_page')->default(10);
            $table->tinyInteger('show_total_number')->default(1);
            $table->tinyInteger('show_archive')->default(1);
            $table->tinyInteger('show_published_at')->default(1);
            $table->tinyInteger('show_updated_at')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_settings');
    }
};
// kiai_loi.le 2024.09.10 feature/setting_base add end
