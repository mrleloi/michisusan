<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqItemTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FaqCategory::factory(15)->hasFaqItems(5)->create();
    }
}
