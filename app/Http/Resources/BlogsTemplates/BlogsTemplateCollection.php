<?php
namespace App\Http\Resources\BlogsTemplates;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogsTemplateCollection extends ResourceCollection
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
            'path' => config('views.blogs_templates.path'),
        ];
    }
}
