<?php

namespace Database\Seeders;

use App\Models\BeforeAfterSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeforeAfterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeforeAfterSetting::factory(1)->create();
    }
}
