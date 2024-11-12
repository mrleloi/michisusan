<?php

namespace App\Services;

use App\Models\HeaderFooterSetting;
use App\Models\Page;

class HeaderFooterService
{
    public function findBySiteId(int $id) {
        return HeaderFooterSetting::where('site_id', $id)->first();
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
        $header_footer_setting = $this->findBySiteId($id);
        $header_footer_setting->update($data);
        $header_footer_setting->touch();
        return $header_footer_setting;
    }
}
