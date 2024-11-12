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
        Schema::table('sites', function (Blueprint $table) {
            $table->string('loading_animation_image', 255)->nullable()->after('loading_animation');
            $table->boolean('loading_animation_enabled')->nullable()->after('loading_animation_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn([
                'loading_animation_image', 'loading_animation_enabled'
            ]);
        });
    }
};
