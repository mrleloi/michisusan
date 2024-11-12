<?php
namespace App\Http\Resources\BlogsCategories;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsCategoryUpdateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description_heading' => $this->description_heading ?? '',
            'description_top' => $this->description_top ?? '',
            'description_bottom' => $this->description_heading ?? '',
            'show_description' => $this->description_heading ?? false,
            'h1_text' => $this->h1_text ?? '',
            'seleted_text' => $this->seleted_text ?? '',
            'link_type' => $this->link_type,
            'link_page_id' => $this->link_page_id ?? null,
            'link_url' => $this->link_url ?? '',
            'link_open_type' => $this->link_open_type,
            'publish_status' => $this->publish_status,
            'order' => $this->order,
        ];
    }
}
