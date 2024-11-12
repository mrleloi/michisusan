<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
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
            'name' => 'メニュー' . self::$so,
            'price' => $this->faker->numberBetween(1000,1000000),
            'append_wave_dash' => $this->faker->boolean(),
            'tax_type' => $this->faker->numberBetween(0,1),
            'description' => $this->faker->realTextBetween(200, 1000),
            'visible' => $this->faker->boolean(90),
            'sort_order' => self::$so++,
        ];
    }
}
