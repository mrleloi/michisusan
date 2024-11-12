<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start : create news_articles table
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
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('news_categories')->onDelete('cascade');
            $table->string('title', 35);
            $table->string('description', 250)->nullable();
            $table->text('content')->nullable();
            $table->string('keywords', 80)->nullable();
            $table->string('eye_catch', 255)->nullable();
            $table->integer('publish_status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
// kiai_loi.le 2024.09.10 feature/setting_base add end
