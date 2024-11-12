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
        Schema::table('image_files', function (Blueprint $table) {
            $table->tinyInteger('quality')->nullable()->comment('1: 軽量, 2:標準, 3:高画質');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('image_files', function (Blueprint $table) {
            $table->dropColumn('quality');
        });
    }
};
