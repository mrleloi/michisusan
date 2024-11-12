<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteJsSetting;
use App\Services\SiteJsSettingService;

class SiteJsSettingController extends Controller
{
    private $siteJsSettingService;

    public function __construct(SiteJsSettingService $siteCssSettingService)
    {
        $this->siteJsSettingService = $siteCssSettingService;
    }

    public function edit(SiteJsSetting $siteJsSetting)
    {
        if (!$siteJsSetting) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'アップロードできませんでした'
            );
        }

        return responseOkAPI(['content' => $siteJsSetting->content]);
    }
}
