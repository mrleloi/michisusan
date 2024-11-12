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
        Schema::create('blogs_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
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
            $table->tinyInteger('show_footer_posts')->default(1);
            $table->string('heading_image', 255)->nullable();
            $table->tinyInteger('show_heading_image')->default(1);
            $table->integer('design_type')->nullable();
            $table->integer('per_page')->default(10);
            $table->tinyInteger('show_total_number')->default(1);
            $table->tinyInteger('show_archive')->default(1);
            $table->tinyInteger('show_published_at')->default(1);
            $table->tinyInteger('show_updated_at')->default(1);
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_settings');
    }
};
