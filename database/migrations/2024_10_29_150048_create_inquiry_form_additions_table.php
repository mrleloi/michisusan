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
        Schema::create('inquiry_form_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_form_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order');
            $table->string('field_name', 250);
            $table->integer('field_type');
            $table->boolean('required')->nullable();;
            $table->text('contents')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_form_additions');
    }
};
