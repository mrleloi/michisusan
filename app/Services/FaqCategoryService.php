<?php

namespace App\Services;

use App\Models\FaqCategory;

class FaqCategoryService extends EmbedPartsService
{
    public function store($params)
    {
        $max = FaqCategory::max('sort_order');
        $params['sort_order'] = $max + 1;

        return FaqCategory::create($params);
    }

    public function getAll($columns = ['id', 'name'])
    {
        $model = FaqCategory::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function list($params)
    {
        $model = FaqCategory::query()->orderBy('sort_order', 'asc')->withCount('faqItems');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return FaqCategory::whereIn('id', $ids)->delete();
    }
}
