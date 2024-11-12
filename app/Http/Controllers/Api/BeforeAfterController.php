<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BeforeAfterCategoryService;
use App\Services\BeforeAfterItemService;
use App\Services\EmbedPartsService;
use Illuminate\Http\Request;

class BeforeAfterController extends Controller
{
    protected $baiService;
    protected $bacService;

    public function __construct(BeforeAfterItemService $baiService, BeforeAfterCategoryService $bacService)
    {
        $this->baiService = $baiService;
        $this->bacService = $bacService;
    }

    public function getCategories()
    {
        try {
            return responseOkAPI($this->bacService->getAll());
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

            return responseOkAPI($this->baiService->getItems(
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
