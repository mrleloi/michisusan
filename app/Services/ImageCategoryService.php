<?php

namespace App\Services;

use App\Models\ImageFileCategory;
use App\Models\ShopItem;
use App\Models\ShopItemAddition;

class ImageCategoryService extends EmbedPartsService
{
    public function findById($id)
    {
        return ImageFileCategory::find($id);
    }

    public function store($params)
    {
        return ImageFileCategory::create($params);
    }

    public function list($params) {
        $model = ImageFileCategory::query();

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return ImageFileCategory::whereIn('id', $ids)->delete();
    }

    public function syncShopItemAdditions(ShopItem $shopItem, $inputShopItemAdditions)
    {
        $index = 0;
        $shopItemAdditions = [];
        foreach($inputShopItemAdditions as $sia) {
            if( !is_null($sia["field_name"]) && $sia["field_name"]!=="" ) {
                $shopItemAdditions[] = [
                    'id' => $sia["id"] !== "" ? $sia["id"] : null,
                    'shop_item_id' => $shopItem->id,
                    'sort_order' => $index++,
                    'field_name' => $sia["field_name"],
                    'contents' => $sia["contents"],
                ];
            }
        }

        ShopItemAddition::where('shop_item_id', $shopItem->id)->delete();
        //\Log::debug("syncShopItemAdditions", [$shopItemAdditions]);
        ShopItemAddition::upsert($shopItemAdditions, ['id']);
    }
}
