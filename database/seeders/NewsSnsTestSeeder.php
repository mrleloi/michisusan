<?php
namespace Database\Seeders;

use App\Models\NewsSns;
use Illuminate\Database\Seeder;

class NewsSnsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsSns::create([
            'site_id' => 1,
            'name' => 'Facebook',
            'is_active' => 1,
        ]);

        NewsSns::create([
            'site_id' => 1,
            'name' => 'X',
            'is_active' => 1,
        ]);
    }
}
