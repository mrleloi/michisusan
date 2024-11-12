<?php

namespace App\Services;

use App\Models\BeforeAfterCategory;
use App\Models\BeforeAfterItem;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use App\Models\Department;
use App\Models\Favorite;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\Inquiry;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Recruiting;
use App\Models\RecruitingCategory;
use App\Models\ShopItem;
use App\Models\StaffMember;
use Illuminate\Support\Facades\DB;

class EmbedPartsService
{
    public const PARTS_TYPE_SHOP_ITEM = 1;
    public const PARTS_TYPE_MENU_ITEM = 2;
    public const PARTS_TYPE_GALLERY_ITEM = 3;
    public const PARTS_TYPE_GALLERY_CATEGORY = 31;
    public const PARTS_TYPE_MENU_CATEGORY = 21;
    public const PARTS_TYPE_GALLERY = 3;
    public const PARTS_TYPE_STAFF_MEMBER = 4;
    public const PARTS_TYPE_DEPARTMENT = 41;
    public const PARTS_TYPE_FAQ_ITEM = 5;
    public const PARTS_TYPE_FAQ_CATEGORY = 51;
    public const PARTS_TYPE_INQUIRY = 5;
    public const PARTS_TYPE_BEFORE_AFTER_ITEM = 6;
    public const PARTS_TYPE_BEFORE_AFTER_CATEGORY = 61;
    public const PARTS_TYPE_FAVORITE = 7;
    public const PARTS_TYPE_RECRUITINGS = 8;
    public const PARTS_TYPE_RECRUITING_CATEGORY = 81;

    public const PER_PAGE_OPTIONS = [
        ['count' => '10', 'label' => '10件表示'],
        ['count' => '20', 'label' => '20件表示'],
        ['count' => '50', 'label' => '50件表示'],
        ['count' => '100', 'label' => '100件表示'],
        ['count' => '200', 'label' => '200件表示'],
    ];

    public const VISIBLE_OPTIONS = [
        ['key' => '1', 'label' => '表示'],
        ['key' => '0', 'label' => '非表示'],
    ];

    public const STATUS_CODES = [
        ['key' => '1', 'label' => '301リダイレクト(恒久的な転送)'],
        ['key' => '2', 'label' => '302リダイレクト(一時的な転送)'],
    ];

    public const START_PAGES = [
        ['key' => '1', 'label' => 'HOME', 'uri' => '/'],
        ['key' => '2', 'label' => 'DASHBOARD', 'uri' => '/dashboard/'],
        ['key' => '3', 'label' => 'USER', 'uri' => '/user/'],
    ];
    public const ANIMATIONS = [
        ['key' => '1', 'label' => 'HOVER_ON'],
        ['key' => '2', 'label' => 'HOVER_OFF'],
    ];

    public const DEFAULT_PER_PAGE = 10;

    protected function getModelClass($type)
    {
        $modelClass = null;

        switch ($type) {
            case self::PARTS_TYPE_SHOP_ITEM:
                $modelClass = ShopItem::class;
                break;
            case self::PARTS_TYPE_MENU_ITEM:
                $modelClass = MenuItem::class;
                break;
            case self::PARTS_TYPE_MENU_CATEGORY:
                $modelClass = MenuCategory::class;
                break;
            case self::PARTS_TYPE_GALLERY_ITEM:
                $modelClass = GalleryItem::class;
                break;
            case self::PARTS_TYPE_GALLERY_CATEGORY:
                $modelClass = GalleryCategory::class;
                break;
            case self::PARTS_TYPE_STAFF_MEMBER:
                $modelClass = StaffMember::class;
                break;
            case self::PARTS_TYPE_FAQ_ITEM:
                $modelClass = FaqItem::class;
                break;
            case self::PARTS_TYPE_FAQ_CATEGORY:
                $modelClass = FaqCategory::class;
                break;
            case self::PARTS_TYPE_DEPARTMENT:
                $modelClass = Department::class;
                break;
            case self::PARTS_TYPE_BEFORE_AFTER_ITEM:
                $modelClass = BeforeAfterItem::class;
                break;
            case self::PARTS_TYPE_RECRUITINGS:
                $modelClass = Recruiting::class;
                break;
            case self::PARTS_TYPE_RECRUITING_CATEGORY:
                $modelClass = RecruitingCategory::class;
                break;
            case self::PARTS_TYPE_BEFORE_AFTER_CATEGORY:
                $modelClass = BeforeAfterCategory::class;
                break;
            case self::PARTS_TYPE_FAVORITE:
                $modelClass = Favorite::class;
                break;
            // case self::PARTS_TYPE_INQUIRY:
            //     $modelClass = Inquiry::class;
            //     break;
            default:
                break;
        }

        return $modelClass;
    }


    public function changeOrder($partsType, $from, $to)
    {
        $modelClass = $this->getModelClass($partsType);

        if ($from != $to) {
            $fromObj = $modelClass::find($from);
            $toObj = $modelClass::find($to);

            $sof = $fromObj->sort_order;
            $fromObj->sort_order = $toObj->sort_order;
            $toObj->sort_order = $sof;

            DB::transaction(function () use ($fromObj, $toObj) {
                $fromObj->save();
                $toObj->save();
            });
        }
    }
}
