<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\BlogsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogsCategoryTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogsCategory::create([
            'site_id' => 1,
            'name' => 'Cate '. Str::random(10),
            'description_heading' => 'Tech Blogs',
            'description_top' => 'Latest updates on technology',
            'description_bottom' => 'Thank you for reading our tech Blogs!',
            'show_description' => 1,
            'h1_text' => 'Technology Blogs',
            'seleted_text' => 'Selected Tech',
            'publish_status' => 1,
        ]);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
