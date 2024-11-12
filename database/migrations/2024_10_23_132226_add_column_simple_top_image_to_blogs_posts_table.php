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
        Schema::table('blogs_posts', function (Blueprint $table) {
            $table->string('simple_top_image_01')->nullable()->after('eye_catch');
            $table->string('simple_top_image_02')->nullable()->after('simple_top_image_01');
            $table->string('simple_top_image_03')->nullable()->after('simple_top_image_02');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs_posts', function (Blueprint $table) {
            $table->dropColumn('simple_top_image_01');
            $table->dropColumn('simple_top_image_02');
            $table->dropColumn('simple_top_image_03');
        });
    }
};
