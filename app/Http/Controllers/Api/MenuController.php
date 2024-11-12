<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuCategoryService;
use App\Services\MenuItemService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $miService;
    protected $mcService;

    public function __construct(MenuItemService $miService, MenuCategoryService $mcService)
    {
        $this->miService = $miService;
        $this->mcService = $mcService;
    }

    public function getCategories()
    {
        try {
            return responseOkAPI($this->mcService->getAll());
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

            return responseOkAPI($this->miService->getItems(
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
