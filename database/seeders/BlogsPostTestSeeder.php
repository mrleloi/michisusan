<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\BlogsPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogsPostTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BlogsPost::create([
        //     'site_id' => 1,
        //     'title' => 'Blog about The Rise of AI - '.  Str::random(10),
        //     'description' => 'AI is taking over the tech world',
        //     'directory' => 'Blogs',
        //     'h1_text' => 'The Rise of AI',
        //     'content' => 'Artificial intelligence (AI) has become a major player in the technology sector...',
        //     'keywords' => 'AI, Technology, Future',
        //     'eye_catch' => 'ai_image.png',
        //     'publish_status' => 1,
        //     'published_at' => now(),
        // ]);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
