<?php

namespace Database\Seeders;

use App\Models\SideBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SideBannerTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SideBanner::create([
            'site_id' => 1,
        ]);
    }
}
