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
        Schema::create('inquiry_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->string('form_name', 20);
            $table->text('form_description')->nullable();
            $table->string('dest_mailaddress', 255);
            $table->string('from_mailaddress', 255);
            $table->text('privacy_policy')->nullable();
            $table->text('finish_message')->nullable();
            $table->string('for_admin_title', 250);
            $table->text('for_admin_body')->nullable();
            $table->string('for_user_title', 250);
            $table->text('for_user_body')->nullable();
            $table->text('for_user_signature')->nullable();
            $table->boolean('add_user_to_reply_to')->nullable();
            $table->text('conversion_tag1')->nullable();
            $table->text('conversion_tag2')->nullable();
            $table->text('conversion_tag3')->nullable();
            $table->tinyInteger('remark_type')->nullable();
            $table->boolean('ignore_unspecified')->nullable();
            $table->text('ignore_ip')->nullable();
            $table->string('recaptcha_site_key', 40)->nullable();
            $table->string('recaptcha_secret_key', 40)->nullable();
            $table->string('smtp_account_name', 100)->nullable();
            $table->string('smtp_password', 64)->nullable();
            $table->string('smtp_server', 255)->nullable();
            $table->integer('smtp_port_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_forms');
    }
};
