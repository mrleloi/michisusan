<?php

namespace App\Http\Resources\SiteJsSetting;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteJsSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'content' => $this->content,
        ];
    }

    private function getName(): string
    {
        return Carbon::parse($this->created_at)->format('Y/m/d H:i:s')
            . ' '
            . optional($this->user)->name
            . 'が保存した独自JS';
    }
}
