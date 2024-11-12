<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FavoriteCategory>
 */
class FavoriteFactory extends Factory
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
            'name' => 'お気に入り' . self::$so,
            'sort_order' => self::$so++,
        ];
    }
}
