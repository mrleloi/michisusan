<?php

namespace Database\Seeders;

use App\Models\BeforeAfterCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeforeAfterItemTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeforeAfterCategory::factory(250)->hasBeforeAfterItems(2)->create();
    }
}
