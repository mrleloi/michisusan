<?php

namespace App\Services;

use App\Models\BeforeAfterCategory;
use App\Models\BeforeAfterItem;
use DB;

class BeforeAfterItemService extends EmbedPartsService
{
    public function store($params)
    {
        $max = BeforeAfterItem::max('sort_order');
        $params['sort_order'] = $max + 1;

        $mi = BeforeAfterItem::create($params);

        return $mi;
    }

    public function getCategoryOfCurrentSite($withDefault = false)
    {
        $result = BeforeAfterCategory::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => 'カテゴリー一覧']], $result);
        } else {
            return $result;
        }
    }

    public function list($params)
    {
        $model = BeforeAfterItem::query()->orderBy('sort_order', 'desc')->with('beforeAfterCategory');

        if (array_key_exists('category_id', $params) && $params['category_id']) {
            $model->whereHas('beforeAfterCategory', function ($q) use ($params) {
                $q->where('before_after_category_id', $params['category_id']);
            });
        }
        if (array_key_exists('visible', $params) && isset($params['visible'])) {
            $model->where('visible', $params['visible']);
        }
        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('title', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function listCategories($params)
    {
        $model = BeforeAfterCategory::query()->orderBy('sort_order', 'desc');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return BeforeAfterItem::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = BeforeAfterCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return BeforeAfterCategory::create($params);
    }

    public function getItems(
        $categorize = true,
        $categoryIds,
        $itemCount = null,
        $siteId,
        $offset = null,
        $columns = ['id', 'name', 'alias']
    ) {
        if ($categorize) {
            $model = BeforeAfterCategory::whereHas('beforeAfterItems', function ($q) use ($itemCount) {
                $q->where('visible', true)->orderBy('sort_order', 'desc');
            })->select($columns)->orderBy('sort_order', 'asc');

            $model->whereIn('id', $categoryIds);

            // TODO: siteId 絞り込み

            $categories =  $model->get();
            $categories->load(['beforeAfterItems' => function ($query) use ($itemCount) {
                $query->orderBy('sort_order', 'asc')->limit($itemCount)
                    ->with('beforeImage')
                    ->with('afterImage');
            }]);
            return $categories;
        } else {
            $model = BeforeAfterItem::query();

            if (is_array($categoryIds)) {
                $model = BeforeAfterItem::whereIn('before_after_category_id', $categoryIds);
            }

            if (!is_null($itemCount)) {
                $model = $model->limit($itemCount);
            }

            if (is_null($offset)) {
                $model = $model->offset($offset);
            }

            $model->with('beforeImage')
                ->with('afterImage')->orderBy('sort_order', 'asc');

            // TODO: siteId 絞り込み

            return [[
                'id' => null,
                'name' => null,
                'alias' => null,
                'before_after_items' => $model->get()
            ]];
        }
    }
}
