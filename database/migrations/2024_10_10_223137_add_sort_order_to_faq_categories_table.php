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
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->bigInteger('sort_order')->after('image3_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
