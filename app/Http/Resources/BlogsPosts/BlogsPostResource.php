<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Resources\BlogsPosts;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogsPostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'categories' => $this->categories->pluck('name'),
            'publish_status' => $this->publish_status,
            'publish_status_text' => $this->publishStatusText(),
            'published_at' => $this->published_at,
            'created_at' => Carbon::parse($this->created_at)->format('Y/m/d H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y/m/d H:i'),
        ];
    }

    public function publishStatusText ()
    {
        return ($this->published_at && $this->publish_status) ? '公開予約' : $this->publish_status_text;
    }

}
// kiai_loi.le 2024.09.10 feature/setting_base add end
