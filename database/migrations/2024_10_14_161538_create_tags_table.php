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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id');
            $table->string('name');
            $table->text('description_top')->nullable();
            $table->text('description_bottom')->nullable();
            $table->tinyInteger('show_description')->default(1);
            $table->string('h1_text', 80)->nullable();
            $table->tinyInteger('publish_status')->default(1)->comment('public:1, private:0');
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
