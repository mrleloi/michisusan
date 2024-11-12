<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteCssSetting;
use App\Services\SiteCssSettingService;

class SiteCssSettingController extends Controller
{
    private $siteCssSettingService;

    public function __construct(SiteCssSettingService $siteCssSettingService)
    {
        $this->siteCssSettingService = $siteCssSettingService;
    }

    public function edit(SiteCssSetting $siteCssSetting)
    {
        if (!$siteCssSetting) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'アップロードできませんでした'
            );
        }

        return responseOkAPI(['content' => $siteCssSetting->content]);
    }
}
