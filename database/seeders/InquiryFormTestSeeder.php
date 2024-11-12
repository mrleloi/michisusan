<?php

namespace Database\Seeders;

use App\Models\InquiryForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InquiryFormTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InquiryForm::factory(2)->hasInquiryLogs(5)->create();
    }
}
