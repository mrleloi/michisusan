<?php

namespace App\Http\Resources\SiteJsSetting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteJsSettingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'path' => config('views.site_js_settings.path'),
        ];
    }
}
