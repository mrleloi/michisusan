<?php

namespace Database\Seeders;

use App\Models\GallerySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySettingTestSeeder extends Seeder
{
    /**Setting
     * Run the database seeds.
     */
    public function run(): void
    {
        GallerySetting::factory(2)->create();
    }
}
