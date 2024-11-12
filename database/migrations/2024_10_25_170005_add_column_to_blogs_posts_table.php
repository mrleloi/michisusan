<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('blogs_posts', function (Blueprint $table) {
            $table->tinyInteger('is_simple')->after('site_id')->default(0)->comment('1: simple, 0:Not simple');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('blogs_posts', function (Blueprint $table) {
            $table->dropColumn('is_simple');
        });
    }
};
