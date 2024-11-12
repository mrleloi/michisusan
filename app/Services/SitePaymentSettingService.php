<?php

namespace App\Services;

use App\Models\SitePaymentSetting;

class SitePaymentSettingService
{
    public function findBySiteId(int $siteId)
    {
        return SitePaymentSetting::where('site_id', $siteId)->first();
    }

    public function createOrUpdate(int $siteId, array $data)
    {
        SitePaymentSetting::query()->updateOrCreate(['site_id' => $siteId], $data);
    }
}
