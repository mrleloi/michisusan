<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    protected static $so = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => 1, // TODO: site_idが使えるレベルになったら調整する
            'gallery_category_id' => GalleryCategory::factory(),
            'title' => 'ギャラリー' . self::$so,
            'subtitle' => 'ギャラリーサブタイトル' . self::$so,
            'summary' => $this->faker->realText(100),
            'description' => $this->faker->realText(200),
            'visible' => $this->faker->boolean(90),
            'sort_order' => self::$so++,
        ];
    }
}
