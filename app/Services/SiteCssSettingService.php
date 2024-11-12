<?php

namespace App\Services;

use App\Models\SiteCssSetting;

class SiteCssSettingService
{
    public function getList()
    {
        $records = SiteCssSetting::query()->latest()->get();

        return $records->skip(1)->values();
    }

    public function getLatest()
    {
        return SiteCssSetting::latest()->first();
    }

    public function find($id)
    {
        return SiteCssSetting::find($id);
    }

    public function create($data)
    {
        return SiteCssSetting::create($data);
    }
}
