<?php
namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phone_call_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id');
            $table->string('page_title')->nullable();
            $table->string('page_location')->nullable();
            $table->string('page_path')->nullable();
            $table->string('button_position')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('access_ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_call_logs');
    }
};
