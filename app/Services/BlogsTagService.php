<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Services;

use App\Models\BlogsTag;

class BlogsTagService
{
    public function getRecentTags()
    {
        return BlogsTag::with('tag')->orderBy('created_at')->limit(5)->get();
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
