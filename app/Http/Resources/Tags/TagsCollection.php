<?php
namespace App\Http\Resources\Tags;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'publish_status_text' => $item->publish_status_text,
                    'order' => $item->order,
                ];
            }),
            'path' => config('views.tags.path'),
        ];
    }
}
