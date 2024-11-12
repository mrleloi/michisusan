<?php

namespace App\Services;

use App\Models\SiteJsSetting;

class SiteJsSettingService
{
    public function getList()
    {
        $records = SiteJsSetting::query()->latest()->get();

        return $records->skip(1)->values();
    }

    public function getLatest()
    {
        return SiteJsSetting::latest()->first();
    }

    public function find($id)
    {
        return SiteJsSetting::find($id);
    }

    public function create($data)
    {
        return SiteJsSetting::create($data);
    }
}
