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
        Schema::table('gallery_items', function (Blueprint $table) {
            //
            $table->text('button1_link_page_url')->after('button1_link_page_id')->nullable();
            $table->text('button2_link_page_url')->after('button2_link_page_id')->nullable();
            $table->text('button3_link_page_url')->after('button3_link_page_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            //
            $table->dropColumn('button1_link_page_url');
            $table->dropColumn('button2_link_page_url');
            $table->dropColumn('button3_link_page_url');
        });
    }
};
