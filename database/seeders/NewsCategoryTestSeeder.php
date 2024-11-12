<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategoryTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsCategory::create([
            'site_id' => 1,
            'name' => 'Technology',
            'description_heading' => 'Tech News',
            'description_top' => 'Latest updates on technology',
            'description_bottom' => 'Thank you for reading our tech news!',
            'show_description' => 1,
            'h1_text' => 'Technology News',
            'seleted_text' => 'Selected Tech',
            'publish_status' => 1,
        ]);

        NewsCategory::create([
            'site_id' => 1,
            'name' => 'Business',
            'description_heading' => 'Business News',
            'description_top' => 'Latest updates on business',
            'description_bottom' => 'Thank you for reading our business news!',
            'show_description' => 1,
            'h1_text' => 'Business News',
            'seleted_text' => 'Selected Business',
            'publish_status' => 1,
        ]);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
