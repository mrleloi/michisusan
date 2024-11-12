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
        Schema::create('blogs_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('title', 35);
            $table->string('description', 250)->nullable();
            $table->text('content')->nullable();
            $table->string('keywords', 80)->nullable();
            $table->string('eye_catch', 255)->nullable();
            $table->integer('publish_status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->boolean('show_tag')->default(false);
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
            $table->string('navigation_name', 35)->nullable();
            $table->string('directory', 30);
            $table->bigInteger('subnavigation_id')->nullable();
            $table->string('h1_text', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_posts');
    }
};
