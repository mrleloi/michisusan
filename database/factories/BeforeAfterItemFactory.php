<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BeforeAfterItem>
 */
class BeforeAfterItemFactory extends Factory
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
            'title' => 'タイトル' . self::$so,
            'content' => $this->faker->realTextBetween(200, 1000),
            'before_image_id' => 1,
            'after_image_id' => 1,
            'visible' => $this->faker->boolean(90),
            'sort_order' => self::$so++,
        ];
    }
}
