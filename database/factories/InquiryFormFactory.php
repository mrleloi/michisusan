<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InquiryForm>
 */
class InquiryFormFactory extends Factory
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
            'form_name' => 'フォーム名' . self::$so,
            'form_description' => $this->faker->realTextBetween(50, 100),
            'dest_mailaddress' => $this->faker->email,
            'from_mailaddress' => $this->faker->email,
            'privacy_policy' =>  $this->faker->realTextBetween(50, 100),
            'finish_message' =>  $this->faker->realTextBetween(50, 100),
            'for_admin_title' => '管理者用タイトル' . self::$so,
            'for_admin_body' => $this->faker->realTextBetween(50, 100),
            'for_user_title' => 'ユーザー用' . $this->faker->realTextBetween(20, 50),
            'for_user_body' => $this->faker->realTextBetween(50, 100),
            'for_user_signature' => $this->faker->realTextBetween(20, 50),
            'add_user_to_reply_to' => $this->faker->boolean(50),
            'conversion_tag1' => $this->faker->randomHtml(2, 2),
            'conversion_tag2' => $this->faker->randomHtml(2, 2),
            'conversion_tag3' => $this->faker->randomHtml(2, 2),
            'remark_type' => $this->faker->randomNumber(1, 2),
            'ignore_unspecified' =>  $this->faker->boolean(50),
            'ignore_ip' => $this->faker->ipv4(),
            'recaptcha_site_key' => 'site_key' . self::$so,
            'recaptcha_secret_key' => 'secret_key' . self::$so++,
            'smtp_account_name' => $this->faker->userName(),
            'smtp_password' =>  $this->faker->password(8, 20),
            'smtp_server' => 'mail.' . $this->faker->domainName(),
            'smtp_port_number' => $this->faker->randomElement([25, 465, 587]),
        ];
    }
}
