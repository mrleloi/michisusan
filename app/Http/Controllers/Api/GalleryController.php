<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GalleryItemService;
use App\Services\GalleryCategoryService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $galleryService;
    protected $gcService;

    public function __construct(GalleryItemService $galleryService, GalleryCategoryService $gcService)
    {
        $this->galleryService = $galleryService;
        $this->gcService = $gcService;
    }

    public function getCategories()
    {
        try {
            return responseOkAPI($this->gcService->getAll());
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function getItemsByCategory(Request $request)
    {
        $request->validate([
            'categorized' => ['boolean'],
            'categoryIds' => ['nullable', 'array'],
            'categoryIds.*' => ['nullable', 'integer'],
            'allCategories' => ['nullable', 'boolean'],
            'itemCount' => ['nullable', 'integer'],
            'siteId' => ['nullable', 'integer'],
        ]);

        try {
            $categoryIds = $request->categoryIds ? : [];

            return responseOkAPI($this->galleryService->getItems(
                $request->categorized,
                $categoryIds,
                $request->itemCount,
                $request->siteId,
            ));
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
