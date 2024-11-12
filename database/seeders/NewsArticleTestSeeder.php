<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsArticle::create([
            'site_id' => 1,
            'title' => 'The Rise of AI',
            'description' => 'AI is taking over the tech world',
            'directory' => 'news',
            'h1_text' => 'The Rise of AI',
            'content' => 'Artificial intelligence (AI) has become a major player in the technology sector...',
            'keywords' => 'AI, Technology, Future',
            'eye_catch' => 'ai_image.png',
            'publish_status' => 1,
            'published_at' => now(),
        ]);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
