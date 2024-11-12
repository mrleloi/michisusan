<?php

namespace App\Services;

use App\Models\MenuCategory;
use DB;

class MenuCategoryService extends EmbedPartsService
{
    public function store($params)
    {
        $max = MenuCategory::max('sort_order');
        $params['sort_order'] = $max + 1;

        return MenuCategory::create($params);
    }

    public function getAll($columns = ['id', 'name'])
    {
        $model = MenuCategory::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function list($params)
    {
        $model = MenuCategory::query()->withCount('menuItem')->orderBy('sort_order', 'desc');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return MenuCategory::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = MenuCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return MenuCategory::create($params);
    }

}
