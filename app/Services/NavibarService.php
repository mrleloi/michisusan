<?php

namespace App\Services;

use App\Models\SideBanner;
use App\Models\Page;

class NavibarService
{
    public function findBySiteId(int $id)
    {
        return SideBanner::where('site_id', $id)->first();
    }
    public function getPages(int $id)
    {
        $pages = Page::where('site_id', $id)->get();
        return $pages->map(function ($page){
            return ['label' => $page->title, 'value' => $page->directory];
        });
    }
    public function update(int $id, array $data)
    {
        $side_banner = $this->findBySiteId($id);
        $side_banner->update($data);
        $side_banner->touch();
        return $side_banner;
    }
}
