<?php

namespace App\Services;

use App\Models\FaqCategory;
use App\Models\FaqItem;

class FaqItemService extends EmbedPartsService
{
    public function getCategoryOfCurrentSite($withDefault = false)
    {
        $result = FaqCategory::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => '組織・役職名一覧']], $result);
        } else {
            return $result;
        }
    }

    public function store($params)
    {
        $max = FaqItem::max('sort_order');
        $params['sort_order'] = $max + 1;

        return FaqItem::create($params);
    }

    public function list($params)
    {
        $model = FaqItem::query()->orderBy('sort_order', 'desc')->with('faqCategory');

        if (array_key_exists('category_id', $params) && $params['category_id']) {
            $model->where('faq_category_id', $params['category_id']);
        }

        if (array_key_exists('visible', $params) && $params['visible']) {
            $model->where('visible', $params['visible']);
        }

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where(function ($q) use ($params) {
                $q->where('question', 'like', "%{$params['keyword']}%")
                    ->orWhere('answer', 'like', "%{$params['keyword']}%");
            });
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return FaqItem::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = FaqCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return FaqCategory::create($params);
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
            $model = FaqCategory::whereHas('faqItems', function ($q) use ($itemCount) {
                $q->where('visible', true)->orderBy('sort_order', 'desc');
            })->select($columns)->orderBy('sort_order', 'asc');

            $model->whereIn('id', $categoryIds);

            // TODO: siteId 絞り込み

            $categories =  $model->get();
            $categories->load(['faqItems' => function ($query) use ($itemCount) {
                $query->orderBy('sort_order', 'asc')->limit($itemCount);
            }]);
            return $categories;
        } else {
            $model = FaqItem::query();

            if (is_array($categoryIds)) {
                $model = FaqItem::whereIn('faq_category_id', $categoryIds);
            }

            if (!is_null($itemCount)) {
                $model = $model->limit($itemCount);
            }

            if (is_null($offset)) {
                $model = $model->offset($offset);
            }

            $model->orderBy('sort_order', 'asc');

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
