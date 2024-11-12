<?php

namespace Database\Factories;

use App\Models\NewsArticle;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsTag>
 */
class NewsTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => 1,
            'news_article_id' => 1,
            'tag_id' => 1,
        ];
    }
}
