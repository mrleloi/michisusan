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
        Schema::create('recruitings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->string('company_name', 250);
            $table->string('url', 500)->nullable();
            $table->string('zip1', 3)->nullable();
            $table->string('zip2', 4)->nullable();
            $table->string('prefecture', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('town', 100)->nullable();
            $table->string('street_address', 100)->nullable();
            $table->string('building', 100)->nullable();
            $table->boolean('visible');
            $table->foreignId('recruiting_category_id')->nullable()->constrained();
            $table->string('title', 250);
            $table->string('occupation', 250);
            $table->string('job_summary', 250);
            $table->text('job_detail');
            $table->string('wp_zip1', 3)->nullable();
            $table->string('wp_zip2', 4)->nullable();
            $table->string('wp_prefecture', 100)->nullable();
            $table->string('wp_city', 100)->nullable();
            $table->string('wp_town', 100)->nullable();
            $table->string('wp_street_address', 100)->nullable();
            $table->string('wp_building', 100)->nullable();
            $table->string('contact_address', 250)->nullable();
            $table->string('pic', 250)->nullable();
            $table->integer('employment_status');
            $table->tinyInteger('salary_type');
            $table->integer('salary_min');
            $table->integer('salary_max');
            $table->text('salary_detail')->nullable();
            $table->bigInteger('image1_id')->nullable();
            $table->string('image1_alt', 250)->nullable();
            $table->bigInteger('image2_id')->nullable();
            $table->string('image2_alt', 250)->nullable();
            $table->bigInteger('image3_id')->nullable();
            $table->string('image3_alt', 250)->nullable();
            $table->tinyInteger('mv_text')->nullable();
            $table->tinyInteger('button_link_type')->nullable();
            $table->bigInteger('button_link_page_id')->nullable();
            $table->text('button_link_page_url')->nullable();
            $table->string('button_text', 100)->nullable();
            $table->tinyInteger('button_link_open_type')->nullable();
            $table->bigInteger('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitings');
    }
};
