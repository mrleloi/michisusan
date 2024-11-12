<?php
namespace Database\Seeders;

use App\Models\BlogsSns;
use Illuminate\Database\Seeder;

class BlogsSnsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogsSns::create([
            'site_id' => 1,
            'name' => 'Facebook',
            'is_active' => 1,
        ]);

        BlogsSns::create([
            'site_id' => 1,
            'name' => 'X',
            'is_active' => 1,
        ]);
    }
}
