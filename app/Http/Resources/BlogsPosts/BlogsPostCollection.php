<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Resources\BlogsPosts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogsPostCollection extends ResourceCollection
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
            'path' => config('views.blogs_posts.path'),
        ];
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
