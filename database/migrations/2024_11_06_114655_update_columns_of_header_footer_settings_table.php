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
        Schema::table('header_footer_settings', function (Blueprint $table) {
            $table->renameColumn('tel1_remarks', 'tel1_remarks_top');
            $table->renameColumn('tel2_remarks', 'tel2_remarks_top');
            $table->string('tel1_remarks_bottom')->nullable()->after('tel1_remarks_top');
            $table->string('tel2_remarks_bottom')->nullable()->after('tel2_remarks_top');
            $table->renameColumn('show_header_logo_image', 'header_logo_image_id');
            $table->bigInteger('header_logo_image_id')->nullable()->change();
            $table->renameColumn('sticky_footer_logo_image', 'footer_logo_image_id');
            $table->bigInteger('footer_logo_image_id')->nullable()->change();
            $table->integer('header_menu_text_weight')->nullable()->after('header_menu_text_font');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('header_footer_settings', function (Blueprint $table) {
            $table->dropColumn([
                'tel1_remarks_bottom',
                'tel2_remarks_bottom',
                'header_menu_text_weight',
            ]);
            $table->renameColumn('tel1_remarks_top', 'tel1_remarks');
            $table->renameColumn('tel2_remarks_top', 'tel2_remarks');
            $table->renameColumn('show_header_logo_image_id', 'header_logo_image');
            $table->bigInteger('show_header_logo_image')->nullable()->change();
            $table->renameColumn('footer_logo_image_id', 'sticky_footer_logo_image');
            $table->string('sticky_footer_logo_image')->nullable()->change();
        });
    }
};
