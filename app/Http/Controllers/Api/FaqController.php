<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FaqCategoryService;
use App\Services\FaqItemService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $fiService;
    protected $fcService;

    public function __construct(FaqItemService $fiService, FaqCategoryService $fcService)
    {
        $this->fiService = $fiService;
        $this->fcService = $fcService;
    }

    public function getCategories()
    {
        try {
            return responseOkAPI($this->fcService->getAll());
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

            return responseOkAPI($this->fiService->getItems(
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
