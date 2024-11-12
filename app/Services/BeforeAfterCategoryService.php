<?php

namespace App\Services;

use App\Models\BeforeAfterCategory;
use DB;

class BeforeAfterCategoryService extends EmbedPartsService
{
    public function store($params)
    {
        $max = BeforeAfterCategory::max('sort_order');
        $params['sort_order'] = $max + 1;

        $mi = BeforeAfterCategory::create($params);

        return $mi;
    }
    
    public function getAll($columns = ['id', 'name'])
    {
        $model = BeforeAfterCategory::query()->orderBy('sort_order', 'asc');
        if($columns) {
            $model->select($columns);
        }

        return $model->get();
    }

    public function list($params)
    {
        $model = BeforeAfterCategory::query()->orderBy('sort_order', 'asc')->withCount('beforeAfterItems');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }    

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }    

    public function deleteAll($ids)
    {
        $result = null;

        DB::transaction(function () use ($ids, &$result) {
            $menuItems = BeforeAfterCategory::whereIn('id', $ids)->get();
            foreach ($menuItems as $menuItem) {
                $menuItem->beforeAfterCategories()->detach();
            }
            $result = BeforeAfterCategory::whereIn('id', $ids)->delete();
        });

        return $result;
    }

}
