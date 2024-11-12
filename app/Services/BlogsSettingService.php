<?php
namespace App\Services;

use App\Models\BlogsPost;
use App\Models\BlogsSetting;
use App\Models\BlogsTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogsSettingService
{
    protected $subnavigationService;

    public function __construct(BlogsSubnavigationService $subnavigationService)
    {
        $this->subnavigationService = $subnavigationService;
    }

    public function getSettingOrFake($siteId)
    {
        $setting = BlogsSetting::query()->where([
            'site_id' => $siteId
        ])->first();

        if (!$setting) {
            $setting = new BlogsSetting([
                'site_id' => $siteId,
                'name' => 'Default Blogs Setting',
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
                'show_footer_posts' => 1,
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
        $blogsSetting = BlogsSetting::updateOrCreate(
            ['site_id' => $data['site_id']],
            $data
        );
        return $blogsSetting;
    }
}
