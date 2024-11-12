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
        Schema::create('recruiting_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiting_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order');
            $table->string('field_name', 250);
            $table->text('contents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiting_additions');
    }
};
