<?php
namespace App\Http\Resources\BlogsSettings;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsSettingUpdateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'site_id' => $this->site_id,
            'name' => $this->name,
            'with_seo_title' => $this->with_seo_title === null ? true : (bool)$this->with_seo_title,
            'directory' => $this->directory,
            'page_title' => $this->page_title,
            'description' => $this->description,
            'h1_text' => $this->h1_text,
            'keywords' => $this->keywords,
            'show_in_header_navimenu' => $this->show_in_header_navimenu === null ? true : (bool)$this->show_in_header_navimenu,
            'show_in_footer_navimenu' => $this->show_in_footer_navimenu === null ? true : (bool)$this->show_in_footer_navimenu,
            'show_in_site_map' => $this->show_in_site_map === null ? true : (bool)$this->show_in_site_map,
            'show_sns' => $this->show_sns === null ? true : (bool)$this->show_sns,
            'show_footer_index' => $this->show_footer_index === null ? true : (bool)$this->show_footer_index,
            'show_footer_posts' => $this->show_footer_posts,
            'heading_image' => $this->heading_image,
            'show_heading_image' => $this->show_heading_image === null ? 1 : (int)$this->show_heading_image,
            'design_type' => $this->design_type,
            'per_page' => $this->per_page,
            'show_total_number' => $this->show_total_number === null ? 1 : (int)$this->show_total_number,
            'show_archive' => $this->show_archive === null ? true : (bool)$this->show_archive,
            'show_published_at' => $this->show_published_at === null ? true : (bool)$this->show_published_at,
            'show_updated_at' => $this->show_updated_at === null ? true : (bool)$this->show_updated_at,
            'top_signature' => $this->top_signature,
            'bottom_signature' => $this->bottom_signature,
            'subnavigation_id' => $this->subnavigation_id ?? null,
            'account' => $this->account,
            'password' => $this->password,
            'custom_head_tag' => $this->custom_head_tag,
            'top_title' => $this->top_title,
            'top_subtitle' => $this->top_subtitle,
            'top_text' => $this->top_text,
            'top_title_position' => $this->top_title_position === null ? 1 : (int)$this->top_title_position,
            'top_text_position' => $this->top_text_position === null ? 1 : (int)$this->top_text_position,
            'bottom_title' => $this->bottom_title,
            'bottom_subtitle' => $this->bottom_subtitle,
            'bottom_text' => $this->bottom_text,
            'bottom_title_position' => $this->bottom_title_position === null ? 1 : (int)$this->bottom_title_position,
            'bottom_text_position' => $this->bottom_text_position === null ? 1 : (int)$this->bottom_text_position,
            'introduction_title' => $this->introduction_title,
            'introduction_image' => $this->introduction_image,
            'introduction' => $this->introduction,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
