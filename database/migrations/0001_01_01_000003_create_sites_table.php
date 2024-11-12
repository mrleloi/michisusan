<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start : create sites table
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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('seo_keyword1', 20)->nullable();
            $table->string('seo_keyword2', 20)->nullable();
            $table->string('seo_keyword3', 20)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
// kiai_loi.le 2024.09.10 feature/setting_base add end
