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
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id'); // 後々外部キーに
            $table->string('name', 100);
            $table->string('zip1', 3)->nullable();
            $table->string('zip2', 4)->nullable();
            $table->tinyInteger('address_type')->nullable();
            $table->string('address1', 100)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('prefecture', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('town', 100)->nullable();
            $table->string('building', 100)->nullable();
            $table->tinyInteger('map_type')->nullable();
            $table->string('tel_no', 21)->nullable();
            $table->string('fax_no', 21)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->bigInteger('sign_logo_image_id')->nullable();
            $table->bigInteger('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_items');
    }
};
