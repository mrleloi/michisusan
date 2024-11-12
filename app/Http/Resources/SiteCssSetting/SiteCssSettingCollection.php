<?php

namespace App\Http\Resources\SiteCssSetting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteCssSettingCollection extends ResourceCollection
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
            'path' => config('views.site_css_settings.path'),
        ];
    }
}
