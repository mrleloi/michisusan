<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuCategory>
 */
class MenuCategoryFactory extends Factory
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
            'name' => 'カテゴリ' . self::$so,
            'alias' => 'カテゴリ別名' . self::$so,
            'description' => $this->faker->realTextBetween(200, 1000),
            'sort_order' => self::$so++,
        ];
    }
}
