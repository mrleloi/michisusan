<?php

namespace App\Services;

use App\Models\BlogsSubnavigation;
use Illuminate\Support\Str;

class BlogsSubnavigationService
{
    public function getAllSubNavigations()
    {
        $subnavigations = BlogsSubnavigation::query()
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
