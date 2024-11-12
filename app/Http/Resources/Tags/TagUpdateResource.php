<?php
namespace App\Http\Resources\Tags;

use Illuminate\Http\Resources\Json\JsonResource;

class TagUpdateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description_top' => $this->description_top ?? '',
            'description_bottom' => $this->description_bottom ?? '',
            'show_description' => $this->show_description ?? false,
            'h1_text' => $this->h1_text ?? '',
            'publish_status' => $this->publish_status,
            'order' => $this->order,
        ];
    }
}
