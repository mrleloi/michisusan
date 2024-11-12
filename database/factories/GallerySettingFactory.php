<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryItem>
 */
class GallerySettingFactory extends Factory
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
            'site_id' => self::$so, // TODO: site_idが使えるレベルになったら調整する
            'page_title' => 'ページタイトル' . self::$so,
            'description' => '説明' . self::$so,
            'h1_text' => 'h1テキスト' . self::$so,
            'navi_display_name' => 'ナビ表示名' . self::$so,
            'directory_name' => 'ディレクトリ名' . self::$so,
            'keywords' => $this->faker->word(),
            'navi_menu' => $this->faker->numberBetween(1, 2),
            'footer' => $this->faker->boolean(75),
            //'header_image_id' => null,
            'show_header_image' => $this->faker->boolean(75),
            'list_design' => $this->faker->numberBetween(1, 5),
            'detail_design' => $this->faker->numberBetween(1, 5),
            'show_detail_page' =>  $this->faker->numberBetween(1, 3),
            'show_inquiry_button' => $this->faker->boolean(75),
            'number_of_items' => array_rand([6,9,12,15,18,21,24,27,30,33,38], 1),
            'number_of_articles' => $this->faker->numberBetween(1, 2),
            'category_navi_type' => $this->faker->numberBetween(1, 3),
            'show_all_name' => '全件表示時の名称' . self::$so,
            'article_order' => $this->faker->numberBetween(1, 2),
            'subnavigation' => $this->faker->numberBetween(1, 3),
            'access_limitation_account' => $this->faker->word(),
            'access_limitation_password' => $this->faker->word(),
            'original_head_tag' => 'オリジナルHEADタグ' . self::$so,
            'above_title' => '上部タイトル' . self::$so,
            'above_subtitle' => '上部タイトル' . self::$so,
            'above_text' => '上部テキスト' . self::$so,
            'above_titles_position' => $this->faker->numberBetween(1, 3),
            'above_text_position' => $this->faker->numberBetween(1, 3),
            'below_title' => '下部タイトル' . self::$so,
            'below_subtitle' => '下部サブタイトル' . self::$so,
            'below_text' => '下部テキスト' . self::$so++,
            'below_titles_position' => $this->faker->numberBetween(1, 3),
            'below_text_position' => $this->faker->numberBetween(1, 3),
        ];
    }
}
