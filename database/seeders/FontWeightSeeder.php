<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FontWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('font_weights')->insert([
            [
                'site_id' => 1,
                'code' => 'FW100',
                'name' => 'Thin',
                'value' => '100',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'site_id' => 1,
                'code' => 'FW200',
                'name' => 'Extra Light',
                'value' => '200',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'site_id' => 1,
                'code' => 'FW300',
                'name' => 'Light',
                'value' => '300',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
