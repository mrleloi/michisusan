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
        Schema::table(
            'sites', function (Blueprint $table) {
            // embedded scripts
            $table->text('head_embedded_script')->nullable();
            $table->text('head_embedded_script2')->nullable();
            $table->text('head_embedded_script3')->nullable();
            $table->text('body_embedded_script')->nullable();
            $table->text('body_embedded_script2')->nullable();
            $table->text('body_embedded_script3')->nullable();
            $table->text('body_tel_script')->nullable();

            // sitemap
            $table->string('sitemap_title', 35)->nullable();
            $table->string('sitemap_description', 250)->nullable();
            $table->string('sitemap_h1', 35)->nullable();
            $table->string('sitemap_keywords', 35)->nullable();
            $table->string('sitemap_subentry', 255)->nullable();
            $table->string('sitemap_entry', 255)->nullable();
            $table->boolean('sitemap_flag')->default(true);
            $table->string('sitemap_link', 255)->nullable();
            $table->string('sitemap_image', 255)->nullable();
        }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'sites', function (Blueprint $table) {
            $table->dropColumn([
                'head_embedded_script',
                'head_embedded_script2',
                'head_embedded_script3',
                'body_embedded_script',
                'body_embedded_script2',
                'body_embedded_script3',
                'body_tel_script',
                'sitemap_title',
                'sitemap_description',
                'sitemap_h1',
                'sitemap_keywords',
                'sitemap_subentry',
                'sitemap_entry',
                'sitemap_flag',
                'sitemap_link',
                'sitemap_image',
            ]);
        }
        );
    }
};
