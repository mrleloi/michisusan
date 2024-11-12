<?php
namespace App\Http\Resources\BlogsPosts;

use App\Models\BlogsSubnavigation;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogsPostUpdateResource extends JsonResource
{
    public function toArray($request)
    {
        $tagsArray = $this->tags->pluck('name')->toArray();
        $snsArray = $this->sns->pluck('id')->toArray();
        $categoriesArray = $this->categories->pluck('id')->toArray();
        $subnavigation = BlogsSubnavigation::query()
            ->where('id', $this->subnavigation_id)
            ->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'h1_text' => $this->h1_text ?? '',
            'navigation_name' => $this->navigation_name ?? '',
            'directory' => $this->directory ?? '',
            'content' => $this->content,
            'keywords' => $this->keywords,
            'tags' => implode(':::', $tagsArray),
            'show_related_tags' => $this->show_tag ?? false,
            'show_common_footer' => $this->show_common_footer ?? false,
            'access_restriction_account' => $this->account ?? '',
            'access_restriction_password' => $this->password ?? '',
            'eye_catch' => $this->eye_catch ?? '',
            'show_header' => $this->show_header ?? false,
            'show_header_logo' => $this->show_header_logo ?? false,
            'show_header_navigation_menu' => $this->show_header_navimenu ?? false,
            'show_header_mv' => $this->show_header_mv ?? false,
            'show_footer' => $this->show_footer ?? false,
            'show_footer_logo' => $this->show_footer_logo ?? false,
            'show_footer_navigation_menu' => $this->show_footer_navimenu ?? false,
            'show_footer_sns' => $this->show_footer_sns ?? false,
            'subnavigation_id' => $subnavigation ?? null,
            'custom_css' => $this->custom_css ?? '',
            'custom_js' => $this->custom_javascript ?? '',
            'custom_head_tag' => $this->custom_head_tag ?? '',
            'is_template' => $this->isTemplate,
            'publish_status' => $this->publish_status == 1 ? 'public' : 'private',
            'published_at' => $this->published_at ?? '',
            'sns_id' => $snsArray,
            'category_id' => $categoriesArray,
        ];
    }
}
