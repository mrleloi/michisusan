<?php

namespace Database\Seeders;

use App\Models\Recruiting;
use App\Models\RecruitingCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecruitingTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RecruitingCategory::factory(250)->hasRecruitings(2)->create();
    }
}
