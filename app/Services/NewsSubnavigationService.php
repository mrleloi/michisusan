<?php

namespace App\Services;

use App\Models\NewsSubnavigation;
use Illuminate\Support\Str;

class NewsSubnavigationService
{
    public function getAllSubNavigations()
    {
        $subnavigations = NewsSubnavigation::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        return $subnavigations->map(function ($subnavigation) {
            return (object) [
                'id' => $subnavigation->id,
                'name' => $subnavigation->name,
                'slug' => $subnavigation->slug,
                'order' => $subnavigation->order,
                'is_active' => $subnavigation->is_active,
            ];
        });
    }
}
