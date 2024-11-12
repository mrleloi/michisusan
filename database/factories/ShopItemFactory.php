<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShopItem>
 */
class ShopItemFactory extends Factory
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
            'name' => $this->faker->company,
            'zip1' => $this->faker->postcode1,
            'zip2' => $this->faker->postcode2,
            'address_type' => $this->faker->numberBetween(0, 1),
            'address1' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress(),
            'address2' => $this->faker->secondaryAddress,
            'prefecture' => $this->faker->prefecture,
            'city' => $this->faker->city,
            'town' => $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
            'map_type' => $this->faker->numberBetween(0, 2),
            'tel_no' => $this->faker->phoneNumber(),
            'fax_no' => $this->faker->phoneNumber(),
            'description' => $this->faker->realTextBetween(200, 1000),
            'sort_order' => self::$so++,
        ];
    }
}
