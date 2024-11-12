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
            $table->text('header_content')->nullable();
            $table->text('sidebar_content')->nullable();
            $table->text('footer_content')->nullable();
            $table->text('sidebar_content2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn([
                'header_content',
                'sidebar_content',
                'footer_content',
                'footer_content',
            ]);
        });
    }
};
