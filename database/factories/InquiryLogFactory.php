<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InquiryLog>
 */
class InquiryLogFactory extends Factory
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
            'received_at' => $this->faker->dateTimeBetween(),
            'mail_body' => $this->faker->realTextBetween(50, 200, 5),
            'user_agent' => $this->faker->userAgent(),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
