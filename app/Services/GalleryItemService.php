<?php

namespace App\Services;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\GalleryItemImage;
use Auth;
use Illuminate\Support\Arr;

class GalleryItemService extends EmbedPartsService
{
    public function store($params)
    {
        $max = GalleryItem::max('sort_order');
        $params['sort_order'] = $max + 1;

        $gi = GalleryItem::create($params);
        $this->syncGalleryItemImages($gi, $params['rows'] ?? []);

        return $gi;
    }

    public function getCategoryOfCurrentSite($withDefault = false)
    {
        $result = GalleryCategory::query()->orderBy('sort_order')->select('id', 'name')->get()->toArray();

        if ($withDefault) {
            return array_merge([['id' => 0, 'name' => 'カテゴリー一覧']], $result);
        } else {
            return $result;
        }
    }

    public function syncGalleryItemImages(GalleryItem $galleryItem, $inputGalleryItemImages)
    {
        $index = 0;
        $galleryItemImages = [];
        foreach ($inputGalleryItemImages as $rows) {
            if (!(is_null($rows["id"]) && is_null(Arr::get($rows, "image_id")))) {
                $galleryItemImages[] = [
                    'id' => $rows["id"] !== "" ? $rows["id"] : null,
                    'gallery_item_id' => $galleryItem->id,
                    'sort_order' => $index++,
                    'image_id' => Arr::get($rows, "image_id_delete") == 1 ? null : $rows["image_id"],
                ];
            }
        }

        GalleryItemImage::where('gallery_item_id', $galleryItem->id)->delete();
        //\Log::debug("syncGalleryItemImages", [$galleryItemImages]);
        GalleryItemImage::upsert($galleryItemImages, ['id']);
    }

    public function getButtonShowTypes()
    {
        return [['key' => '1', 'label' => '表示しない', 'db_value' => false], ['key' => '2', 'label' => '表示する', 'db_value' => true]];
    }

    public function getButtonLinkTypes()
    {
        return [['key' => '1', 'label' => 'サイト内リンク'], ['key' => '2', 'label' => '外部リンク']];
    }

    public function getButtonLinkOpenTypes()
    {
        return [['key' => '1', 'label' => '同一ウィンドウで開く'], ['key' => '2', 'label' => '別ウィンドウで開く']];
    }

    public function list($params)
    {
        $model = GalleryItem::query()->orderBy('sort_order', 'desc')->with('image')->with('galleryCategory');

        if (array_key_exists('category_id', $params) && $params['category_id']) {
            $model->where('gallery_category_id', $params['category_id']);
        }
        if (array_key_exists('visible', $params) && isset($params['visible'])) {
            $model->where('visible', $params['visible']);
        }
        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('title', 'like', "%{$params['keyword']}%")
                ->orWhere('subtitle', 'like', "%{$params['keyword']}%");
            // ->orWhere('summary', 'like', "%{$params['keyword']}%")
            // ->orWhere('description', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        GalleryItem::whereIn('id', $ids)->delete();
    }

    public function registerCategory($params)
    {
        $max = GalleryCategory::max('sort_order');
        $params['sort_order'] = $max + 1;
        $params['visible'] = 1;

        return GalleryCategory::create($params);
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
            $model = GalleryCategory::whereHas('galleryItems', function ($q) use ($itemCount) {
                $q->where('visible', true)->orderBy('sort_order', 'desc');
            })->select($columns)->orderBy('sort_order', 'asc');

            $model->whereIn('id', $categoryIds);

            // TODO: siteId 絞り込み

            $categories =  $model->get();
            $categories->load(['galleryItems' => function ($query) use ($itemCount) {
                $query->orderBy('sort_order', 'asc')->limit($itemCount)
                    ->with('image')->with('galleryItemImages');
            }]);
            return $categories;
        } else {
            $model = GalleryItem::query();

            if (is_array($categoryIds)) {
                $model = GalleryItem::whereIn('gallery_category_id', $categoryIds);
            }

            if (!is_null($itemCount)) {
                $model = $model->limit($itemCount);
            }

            if (is_null($offset)) {
                $model = $model->offset($offset);
            }

            $model->with('image')->with('galleryItemImages')->orderBy('sort_order', 'asc');

            // TODO: siteId 絞り込み

            return $model->get();
        }
    }
}
