<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recruiting>
 */
class RecruitingFactory extends Factory
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
            'company_name' => 'かいしゃ' . self::$so,
            'url' => $this->faker->url,
            'zip1' => $this->faker->postcode1,
            'zip2' => $this->faker->postcode2,
            'prefecture' => $this->faker->prefecture,
            'city' => $this->faker->city,
            'town' => $this->faker->streetAddress,
            'street_address' => $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
            'visible' => $this->faker->boolean(90),
            'title' => '募集タイトル' . self::$so,
            'occupation' => '募集職種' . self::$so,
            'job_summary' => $this->faker->realTextBetween(50, 100),
            'job_detail' => $this->faker->realTextBetween(100, 400),
            'wp_zip1' => $this->faker->postcode1,
            'wp_zip2' => $this->faker->postcode2,
            'wp_prefecture' => $this->faker->prefecture,
            'wp_city' => $this->faker->city,
            'wp_town' => $this->faker->streetAddress,
            'wp_street_address' => $this->faker->streetAddress,
            'wp_building' => $this->faker->secondaryAddress,
            'contact_address' => '連絡先' . self::$so,
            'pic' => '担当者' . self::$so,
            'employment_status' => $this->faker->numberBetween(1, 5),
            'salary_type' => $this->faker->numberBetween(1, 3),
            'salary_min' => $this->faker->numberBetween(1000, 5000),
            'salary_max' => $this->faker->numberBetween(5000, 10000),
            'salary_detail' => $this->faker->realTextBetween(100, 400),
            'mv_text' => $this->faker->numberBetween(1, 3),
            'button_link_type' => $this->faker->numberBetween(1, 2),
            'button_link_page_id' => self::$so,
            'button_link_page_url' => 'http://button.url/' . self::$so,
            'button_text' => 'ボタンラベル' . self::$so,
            'button_link_open_type' => $this->faker->numberBetween(1, 2),
            'sort_order' => self::$so++,
        ];
    }
}
