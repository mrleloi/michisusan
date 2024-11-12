<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use App\Models\NewsTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsTagTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsTagCategories = NewsArticle::all();

        foreach ($newsTagCategories as $newsTagCategory) {
            NewsTag::factory(1)->create(['site_id' => $newsTagCategory->site_id, 'news_article_id' => $newsTagCategory->id]);
        }
    }
}
