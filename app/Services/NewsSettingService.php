<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Services;

use App\Models\NewsArticle;
use App\Models\NewsSetting;
use App\Models\NewsTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsSettingService
{
    protected $subnavigationService;

    public function __construct(NewsSubnavigationService $subnavigationService)
    {
        $this->subnavigationService = $subnavigationService;
    }

    public function getSettingOrFake($siteId)
    {
        $setting = NewsSetting::query()->where([
            'site_id' => $siteId
        ])->first();

        if (!$setting) {
            $setting = new NewsSetting([
                'site_id' => $siteId,
                'name' => 'Default News Setting',
                'with_seo_title' => 0,
                'directory' => '',
                'page_title' => '',
                'description' => '',
                'h1_text' => '',
                'keywords' => '',
                'show_in_header_navimenu' => 1,
                'show_in_footer_navimenu' => 1,
                'show_in_site_map' => 1,
                'show_sns' => 1,
                'show_footer_index' => 1,
                'show_footer_articles' => 1,
                'heading_image' => '',
                'show_heading_image' => 1,
                'design_type' => 1,
                'per_page' => 10,
                'show_total_number' => 1,
                'show_archive' => 1,
                'show_published_at' => 1,
                'show_updated_at' => 1,
                'top_signature' => '',
                'bottom_signature' => '',
                'subnavigation_id' => null,
                'account' => '',
                'password' => '',
                'custom_head_tag' => '',
                'top_title' => '',
                'top_subtitle' => '',
                'top_text' => '',
                'top_title_position' => null,
                'top_text_position' => null,
                'bottom_title' => '',
                'bottom_subtitle' => '',
                'bottom_text' => '',
                'bottom_title_position' => null,
                'bottom_text_position' => null,
                'introduction_title' => '',
                'introduction_image' => '',
                'introduction' => '',
            ]);
        }

        return $setting;
    }

    public function getAllDesigns()
    {
        $fakeData = [
            (object)[
                'id' => 1,
                'text' => 'Design type 1',
                'image' => 'null.png',
                'isPublic' => true
            ],
            (object)[
                'id' => 2,
                'text' => 'Design type 1',
                'image' => 'null.png',
                'isPublic' => true
            ],
            (object)[
                'id' => 3,
                'text' => 'Design type 3',
                'image' => 'null.png',
                'isPublic' => true
            ],
            (object)[
                'id' => 4,
                'text' => 'Design type 4',
                'image' => 'null.png',
                'isPublic' => true
            ],
            (object)[
                'id' => 5,
                'text' => 'Design type 5',
                'image' => 'null.png',
                'isPublic' => true
            ],
            (object)[
                'id' => 6,
                'text' => 'Design type 6',
                'image' => 'null.png',
                'isPublic' => true
            ],
        ];
        return $fakeData;
    }


    public function updateSetting(array $data)
    {
        $newsSetting = NewsSetting::updateOrCreate(
            ['site_id' => $data['site_id']],
            $data
        );
        return $newsSetting;
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
