<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fonts')->insert([
            [
                'site_id' => 1,
                'code' => 'font001',
                'name' => 'Arial',
                'value' => 'arial.ttf',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'site_id' => 2,
                'code' => 'font002',
                'name' => 'Helvetica',
                'value' => 'helvetica.ttf',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'site_id' => 3,
                'code' => 'font003',
                'name' => 'Times New Roman',
                'value' => 'times_new_roman.ttf',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
