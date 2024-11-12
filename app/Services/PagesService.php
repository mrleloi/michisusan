<?php

namespace App\Services;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PagesService
{
    public function getAll()
    {
        $pages = Page::whereNull('page_id')->with('children')->get();
        foreach($pages as $p){
            foreach($p->children as $c){
                $c->children;
            }
        }
        return $pages;
    }
    public function findById(int $id)
    {
        return Page::find($id);
    }
    public function create(array $data)
    {
        return Page::create($data);
    }
    public function update(int $id, array $data)
    {
        $page = $this->findById($id);
        $page->update($data);
        return $page;
    }
}
