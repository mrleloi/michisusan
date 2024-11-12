<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Resources\NewsCategories;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'publish_status' => $this->publish_status,
            'publish_status_text' => $this->publish_status_text,
            'order' => $this->order,
            'published_at' => $this->published_at,
            'created_at' => Carbon::parse($this->created_at)->format('Y/m/d H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y/m/d H:i'),
        ];
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
