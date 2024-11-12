<?php

namespace App\Services;

use App\Models\GalleryCategory;
use App\Models\GallerySetting;
use App\Models\GallerySettingImage;
use Auth;
use Illuminate\Support\Arr;

class GallerySettingService extends EmbedPartsService
{
    public function store($params)
    {
        $gi = GallerySetting::create($params);

        return $gi;
    }

    public function getVisibleOptions()
    {
        return [
            ['key' => '1', 'label' => '表示する'],
            ['key' => '0', 'label' => '表示しない'],
        ];
    }
    public function getNaviMenuTypes()
    {
        return [
            ['key' => '1', 'label' => 'ナビメニューに表示する'],
            ['key' => '2', 'label' => '下部ナビメニューに表示する'],
            ['key' => '3', 'label' => 'サイトマップに載せる'],
        ];
    }

    public function getFooterTypes()
    {
        return [
            ['key' => '1', 'label' => 'SNSボタンに表示する'],
            ['key' => '2', 'label' => '共通フッターを表示する'],
        ];
    }

    public function getListDesignTypes()
    {
        return [
            ['key' => '1', 'label' => 'デザイン(1カラム)1', 'filename' => ''],
            ['key' => '2', 'label' => 'デザイン(1カラム)2', 'filename' => ''],
            ['key' => '3', 'label' => 'デザイン(1カラム)3', 'filename' => ''],
            ['key' => '4', 'label' => 'デザイン(1カラム)4', 'filename' => ''],
            ['key' => '5', 'label' => 'デザイン(1カラム)5', 'filename' => ''],
            ['key' => '6', 'label' => 'デザイン(1カラム)6', 'filename' => ''],
            ['key' => '7', 'label' => 'デザイン(1カラム)7', 'filename' => ''],
            ['key' => '8', 'label' => 'デザイン(1カラム)8', 'filename' => ''],
        ];
    }

    public function getDetailDesignTypes()
    {
        return [
            ['key' => '1', 'label' => 'デザイン(1カラム)1', 'filename' => ''],
            ['key' => '2', 'label' => 'デザイン(1カラム)2', 'filename' => ''],
            ['key' => '3', 'label' => 'デザイン(1カラム)3', 'filename' => ''],
            ['key' => '4', 'label' => 'デザイン(1カラム)4', 'filename' => ''],
            ['key' => '5', 'label' => 'デザイン(1カラム)5', 'filename' => ''],
            ['key' => '6', 'label' => 'デザイン(1カラム)6', 'filename' => ''],
            ['key' => '7', 'label' => 'デザイン(1カラム)7', 'filename' => ''],
            ['key' => '8', 'label' => 'デザイン(1カラム)8', 'filename' => ''],
        ];
    }

    public function getShowDetailPageTypes()
    {
        return [
            ['key' => '1', 'label' => '表示しない'],
            ['key' => '2', 'label' => '表示する（スライダー画像）'],
            ['key' => '3', 'label' => '表示する（ポップアップ画像）'],
        ];
    }

    public function getNumberOfItemsTypes()
    {
        return [
            ['key' => '6', 'label' => '6件'],
            ['key' => '9', 'label' => '9件'],
            ['key' => '12', 'label' => '12件'],
            ['key' => '15', 'label' => '15件'],
            ['key' => '18', 'label' => '18件'],
            ['key' => '21', 'label' => '21件'],
            ['key' => '24', 'label' => '24件'],
            ['key' => '27', 'label' => '27件'],
            ['key' => '30', 'label' => '30件'],
            ['key' => '33', 'label' => '33件'],
            ['key' => '36', 'label' => '36件'],
        ];
    }

    public function getCategoryNaviTypes()
    {
        return [
            ['key' => '1', 'label' => '上に表示する'],
            ['key' => '2', 'label' => '下に表示する'],
            ['key' => '3', 'label' => '表示しない'],
        ];
    }

    public function getArticleOrderTypes()
    {
        return [
            ['key' => '1', 'label' => '古い順に表示'],
            ['key' => '2', 'label' => '新しい順に表示'],
        ];
    }

    public function getSubnavigationTypes()
    {
        return [
            ['key' => '1', 'label' => 'サブナビゲーション1'],
            ['key' => '2', 'label' => 'サブナビゲーション2'],
        ];
    }

    public function getPositionTypes()
    {
        return [
            ['key' => '1', 'label' => '左揃え'],
            ['key' => '2', 'label' => '中央揃え'],
            ['key' => '3', 'label' => '右揃え'],
        ];
    }
}
