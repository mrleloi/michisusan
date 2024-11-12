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
        Schema::create('site_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('site_id');
            $table->boolean('show_payment_button')->nullable()->default(true);
            $table->boolean('show_paypal')->nullable()->default(true);
            $table->boolean('show_aupay')->nullable()->default(true);
            $table->boolean('show_dpay')->nullable()->default(true);
            $table->boolean('show_merpay')->nullable()->default(true);
            $table->boolean('show_rakutenpay')->nullable()->default(true);
            $table->boolean('show_visa')->nullable()->default(true);
            $table->boolean('show_master')->nullable()->default(true);
            $table->boolean('show_jcb')->nullable()->default(true);
            $table->boolean('show_amex')->nullable()->default(true);
            $table->boolean('show_diners')->nullable()->default(true);
            $table->boolean('show_discover')->nullable()->default(true);
            $table->boolean('show_unionpay')->nullable()->default(true);
            $table->boolean('show_electronicmoney')->nullable()->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_payment_settings');
    }
};
