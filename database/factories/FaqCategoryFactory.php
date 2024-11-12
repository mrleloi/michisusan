<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FaqCategory>
 */
class FaqCategoryFactory extends Factory
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
            'name' => 'FAQカテゴリー' . self::$so,
            'alias' => 'FAQカテゴリー別名' . self::$so,
            'description' => $this->faker->realTextBetween(20,200),
            'sort_order' => self::$so++,
        ];
    }
}
