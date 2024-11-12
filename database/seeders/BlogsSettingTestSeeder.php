<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\BlogsArticle;
use App\Models\BlogsSetting;
use Illuminate\Database\Seeder;

class BlogsSettingTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogsSetting = BlogsSetting::query()->latest()->first();
        if (!$blogsSetting) {
            BlogsSetting::create([
                'site_id' => 1,
                'name' => 'Blogs Settings',
                'with_seo_title' => 1,
                'directory' => 'latestBlogs',
                'page_title' => 'Latest Blogs',
                'description' => 'All about the latest in Blogs',
                'h1_text' => 'Latest Blogs',
                'keywords' => 'Tech, AI, Gadgets',
                'show_in_header_navimenu' => 1,
                'show_in_footer_navimenu' => 1,
                'show_in_site_map' => 1,
                'show_sns' => 1,
                'show_footer_index' => 1,
                'show_footer_posts' => 1,
                'heading_image' => '',
                'show_heading_image' => 1,
                'design_type' => 1,
                'per_page' => 10,
                'show_total_number' => 1,
                'show_archive' => 1,
                'show_published_at' => 1,
                'show_updated_at' => 1,
            ]);
        }
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
