<?php

namespace App\Services;

use App\Models\SiteSnsSetting;
use Illuminate\Support\Str;

class SiteSnsSettingService
{
    public function updateOrCreate(int $siteId, array $data): void
    {
        SiteSnsSetting::query()->updateOrCreate(['site_id' => $siteId], $data);
    }

    public function findBySiteId($siteId)
    {
        return SiteSnsSetting::query()->where('site_id', $siteId)->first();
    }

    public function deleteImages(array $imageKeys)
    {
        foreach ($imageKeys as $key => $status) {
            if ($status) {
                $keyReplaced = Str::replace('_delete', '', $key);

                $siteSnsSetting = $this->findBySiteId(auth()->user()->site_id ?: 1);
                $siteSnsSetting->{$keyReplaced} = null;
                $siteSnsSetting->save();
            }
        }
    }
}
