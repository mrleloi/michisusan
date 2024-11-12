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
        Schema::create('site_redirect_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->string('slug_source', 100)->unique();
            $table->string('slug_target', 100);
            $table->tinyInteger('status_code')->comment('1: Status 301, 2: Status 302');
            $table->timestamp('redirect_start')->nullable();
            $table->timestamp('redirect_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_redirect_records');
    }
};
