<?php

namespace App\Services;

use App\Models\RecruitingCategory;
use DB;

class RecruitingCategoryService extends EmbedPartsService
{
    public function store($params)
    {
        $max = RecruitingCategory::max('sort_order');
        $params['sort_order'] = $max + 1;

        return RecruitingCategory::create($params);
    }

    public function getAll($columns = ['id', 'name'])
    {
        $model = RecruitingCategory::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function list($params)
    {
        $model = RecruitingCategory::query()->orderBy('sort_order', 'asc')->withCount('recruitings');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
            $model->orWhere('alias', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return RecruitingCategory::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = RecruitingCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return RecruitingCategory::create($params);
    }

}
