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
        Schema::create('blogs_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('description_heading', 80)->nullable();
            $table->text('description_top')->nullable();
            $table->text('description_bottom')->nullable();
            $table->tinyInteger('show_description')->nullable()->default(1);
            $table->string('h1_text', 80)->nullable();
            $table->string('seleted_text', 80)->nullable();
            $table->integer('link_type')->nullable();
            $table->bigInteger('link_page_id')->nullable();
            $table->string('link_url', 500)->nullable();
            $table->integer('link_open_type')->nullable()->default(1);
            $table->integer('publish_status')->nullable()->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_categories');
    }
};
