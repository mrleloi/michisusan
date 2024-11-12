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
        Schema::table('sites', function (Blueprint $table) {
            $table->string('email_address', 255)->nullable();
            $table->string('ga4_property_id', 255)->nullable();
            $table->string('ga4_json_file', 255)->nullable();
            $table->text('ga4_tracking_code')->nullable();
            $table->string('search_console_meta', 255)->nullable();
            $table->string('search_console_json_file', 255)->nullable();
            $table->text('microsoft_clarity_tag')->nullable();
            $table->text('juicer_tag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn([
                'email_address',
                'ga4_property_id',
                'ga4_json_file',
                'ga4_tracking_code',
                'search_console_meta',
                'search_console_json_file',
                'microsoft_clarity_tag',
                'juicer_tag',
            ]);
        });
    }
};
