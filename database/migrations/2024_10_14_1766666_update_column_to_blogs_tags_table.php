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
        Schema::table('blogs_tags', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->bigInteger('tag_id')->after('blogs_post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('blogs_tags', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('tag_id');
        });
    }
};