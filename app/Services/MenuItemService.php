<?php

namespace App\Services;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use DB;

class MenuItemService extends EmbedPartsService
{
    public function store($params)
    {
        $max = MenuItem::max('sort_order');
        $params['sort_order'] = $max + 1;

        $mi = MenuItem::create($params);
        $this->syncCategory($mi, $params['menu_category_id']);

        return $mi;
    }

    public function getCategoryOfCurrentSite($withDefault = false)
    {
        $result = MenuCategory::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();
        // $result = array_map(function ($item) {
        //     return array_map('strval', $item);
        // }, $result);

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => 'カテゴリー一覧']], $result);
        } else {
            return $result;
        }
    }

    public function getTaxTypes()
    {
        return [['key' => '1', 'label' => '税抜'], ['key' => '2', 'label' => '税込'], ['key' => '9', 'label' => 'なし']];
    }

    public function list($params)
    {
        $model = MenuItem::query()->orderBy('sort_order', 'desc')->with('menuCategories');

        if (array_key_exists('category_id', $params) && $params['category_id']) {
            $model->whereHas('menuCategories', function ($q) use ($params) {
                $q->where('menu_category_id', $params['category_id']);
            });
        }
        if (array_key_exists('visible', $params) && isset($params['visible'])) {
            $model->where('visible', $params['visible']);
        }
        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function listCategories($params)
    {
        $model = MenuCategory::query()->orderBy('sort_order', 'desc');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        $result = null;

        DB::transaction(function () use ($ids, &$result) {
            $menuItems = MenuItem::whereIn('id', $ids)->get();
            foreach ($menuItems as $menuItem) {
                $menuItem->menuCategories()->detach();
            }
            $result = MenuItem::whereIn('id', $ids)->delete();
        });

        return $result;
    }

    public function registerCategory($params)
    {
        $max = MenuCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return MenuCategory::create($params);
    }

    public function syncCategory($menuItem, $categories)
    {
        $menuItem->menuCategories()->sync($categories);
    }

    public function getItems(
        $categorize = true,
        $categoryIds,
        $itemCount = null,
        $siteId,
        $offset = null,
        $columns = ['id', 'name']
    ) {
        if ($categorize) {
            $model = MenuCategory::whereHas('menuItem', function ($q) use ($itemCount) {
                $q->where('visible', true)->orderBy('sort_order', 'desc');
            })->select($columns)->orderBy('sort_order', 'asc');

            $model->whereIn('id', $categoryIds);

            // TODO: siteId 絞り込み

            $categories =  $model->get();
            $categories->load(['menuItem' => function ($query) use ($itemCount) {
                $query->orderBy('sort_order', 'asc')->limit($itemCount)
                    ->with('image1')
                    ->with('image2')
                    ->with('image3');
            }]);
            return $categories;
        } else {
            $model = MenuItem::query();

            if (is_array($categoryIds)) {
                $model = MenuItem::whereIn('menu_category_id', $categoryIds);
            }

            if (!is_null($itemCount)) {
                $model = $model->limit($itemCount);
            }

            if (is_null($offset)) {
                $model = $model->offset($offset);
            }

            $model->with('image1')->with('image2')->with('image3')->orderBy('sort_order', 'asc');

            // TODO: siteId 絞り込み

            return [[
                'id' => null,
                'name' => null,
                'alias' => null,
                'menu_items' => $model->get()
            ]];
        }
    }
}
