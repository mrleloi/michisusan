<?php

namespace Database\Seeders;

use App\Models\ImageFileCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageFileTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // カテゴリだけ追加しておく。画像はアップロードしよう
        ImageFileCategory::factory(20)->create();
    }
}
