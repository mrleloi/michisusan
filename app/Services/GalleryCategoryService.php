<?php

namespace App\Services;

use App\Models\GalleryCategory;
use DB;

class GalleryCategoryService extends EmbedPartsService
{
    public function store($params)
    {
        $max = GalleryCategory::max('sort_order');
        $params['sort_order'] = $max + 1;

        return GalleryCategory::create($params);
    }

    public function list($params)
    {
        $model = GalleryCategory::query()->orderBy('sort_order', 'desc')->withCount('galleryItems');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function getAll($columns = ['id', 'name'])
    {
        $model = GalleryCategory::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function deleteAll($ids)
    {
        return GalleryCategory::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = GalleryCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return GalleryCategory::create($params);
    }

}
