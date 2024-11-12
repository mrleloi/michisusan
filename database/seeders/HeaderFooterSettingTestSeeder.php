<?php

namespace Database\Seeders;

use App\Models\HeaderFooterSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderFooterSettingTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeaderFooterSetting::create([
            'site_id' => 1,
        ]);
    }
}
