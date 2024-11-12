<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GalleryItemTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryCategory::factory(5)
            ->hasGalleryItems(10)
            ->create();
    }
}
