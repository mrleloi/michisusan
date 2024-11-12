<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StaffMember>
 */
class StaffMemberFactory extends Factory
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
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'another_name' => '別名' . self::$so,
            'visible' => $this->faker->boolean(90),
            'sort_order' => self::$so++,
        ];
    }
}
