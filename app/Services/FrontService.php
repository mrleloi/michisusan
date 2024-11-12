<?php

namespace App\Services;

use App\Models\Site;
use App\Models\Page;

class FrontService
{

    public function getSiteSettings()
    {
        return Site::find(1);
    }

    public function getPage($path)
    {
        if ($path == '/') {
            return Page::whereNull('page_id')->where('directory', $path)->first();
        }
        $paths = explode('/', $path);
        $page = null;
        foreach ($paths as $dir) {
            $page = Page::where('page_id', $page?->id)->where('directory', $dir)->first();
            if (!$page) {
                return null;
            }
        }
        return $page;
    }

    public function getMenu($page)
    {
        $subnavi = $page?->subnavigation;
        if ($subnavi) {
            // 起点ページの子ページを取得
            return Page::where('page_id', $subnavi->start_page_id)->get();
        } else {
            // 第一階層のページだけを取得
            return Page::whereNull('page_id')->whereNot('directory', '/')->get();
        }
    }
}
