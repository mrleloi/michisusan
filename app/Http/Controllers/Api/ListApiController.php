<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmbedPartsService;
use Illuminate\Http\Request;

class ListApiController extends Controller
{
    protected $epService;

    public function __construct(EmbedPartsService $epService)
    {
        $this->epService = $epService;
    }

    public function changeOrder($listType, Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $partsType = null;

        switch ($listType) {
            case 'shop_item':
                $partsType = EmbedPartsService::PARTS_TYPE_SHOP_ITEM;
                break;
            case 'menu_item':
                $partsType = EmbedPartsService::PARTS_TYPE_MENU_ITEM;
                break;
            case 'menu_category':
                $partsType = EmbedPartsService::PARTS_TYPE_MENU_CATEGORY;
                break;
            case 'gallery_item':
                $partsType = EmbedPartsService::PARTS_TYPE_GALLERY_ITEM;
                break;
            case 'gallery_category':
                $partsType = EmbedPartsService::PARTS_TYPE_GALLERY_CATEGORY;
                break;
            case 'before_after_item':
                $partsType = EmbedPartsService::PARTS_TYPE_BEFORE_AFTER_ITEM;
                break;
            case 'before_after_category':
                $partsType = EmbedPartsService::PARTS_TYPE_BEFORE_AFTER_CATEGORY;
                break;
            case 'faq_item':
                $partsType = EmbedPartsService::PARTS_TYPE_FAQ_ITEM;
                break;
            case 'faq_category':
                $partsType = EmbedPartsService::PARTS_TYPE_FAQ_CATEGORY;
                break;
            case 'staff_member':
                $partsType = EmbedPartsService::PARTS_TYPE_STAFF_MEMBER;
                break;
            case 'department':
                $partsType = EmbedPartsService::PARTS_TYPE_DEPARTMENT;
                break;
            case 'recruiting':
                $partsType = EmbedPartsService::PARTS_TYPE_RECRUITINGS;
                break;
            case 'recruiting_category':
                $partsType = EmbedPartsService::PARTS_TYPE_RECRUITING_CATEGORY;
                break;
            default:
                break;
        }

        $this->epService->changeOrder($partsType, $from, $to);
    }
}
