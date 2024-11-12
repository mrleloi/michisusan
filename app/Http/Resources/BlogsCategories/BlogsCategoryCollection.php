<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Resources\BlogsCategories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogsCategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection,
            'path' => config('views.blogs_categories.path'),
        ];
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
