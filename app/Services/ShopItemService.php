<?php

namespace App\Services;

use App\Models\ShopItem;
use App\Models\ShopItemAddition;

class ShopItemService extends EmbedPartsService
{
    public function store($params)
    {
        $max = ShopItem::max('sort_order');
        $params['sort_order'] = $max + 1;

        $si = ShopItem::create($params);
        $this->syncShopItemAdditions($si, $params['rows'] ?? []);

        return $si;
    }

    public function list($params)
    {
        $model = ShopItem::query()->orderBy('sort_order', 'desc');

        if (array_key_exists('keyword', $params) && $params['keyword']) {
            $model->where('name', 'like', "%{$params['keyword']}%");
        }

        return $model->paginate($params['per_page'] ?? self::DEFAULT_PER_PAGE);
    }

    public function deleteAll($ids)
    {
        return ShopItem::whereIn('id', $ids)->delete();
    }

    public function syncShopItemAdditions(ShopItem $shopItem, $inputShopItemAdditions)
    {
        $index = 0;
        $shopItemAdditions = [];
        foreach ($inputShopItemAdditions as $rows) {
            if (!is_null($rows["field_name"]) && $rows["field_name"] !== "") {
                $shopItemAdditions[] = [
                    'id' => $rows["id"] !== "" ? $rows["id"] : null,
                    'shop_item_id' => $shopItem->id,
                    'sort_order' => $index++,
                    'field_name' => $rows["field_name"],
                    'contents' => $rows["contents"],
                ];
            }
        }

        ShopItemAddition::where('shop_item_id', $shopItem->id)->delete();
        //\Log::debug("syncShopItemAdditions", [$shopItemAdditions]);
        ShopItemAddition::upsert($shopItemAdditions, ['id']);
    }

    public function getAddressTypes()
    {
        return [['key' => '1', 'label' => '簡易入力'], ['key' => '2', 'label' => '詳細入力']];
    }

    public function getMapTypes()
    {
        return [['key' => '1', 'label' => '地図非表示'], ['key' => '2', 'label' => '住所情報から地図を表示する'], ['key' => '3', 'label' => '地図を埋め込む']];
    }

    public function getItems(
        $siteId
    ) {
        $model = ShopItem::query();

        $model->select(['id', 'name']);

        // TODO: siteId 絞り込み

        return $model->orderBy('sort_order', 'asc')->get();
    }

    public function getItem($id, $siteId)
    {
        $model = ShopItem::where('id', $id);

        $model->with('image')->with('shopItemAdditions');

        // TODO: siteId 絞り込み

        return $model->first();
    }
}
