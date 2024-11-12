<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShopItemService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $siService;

    public function __construct(ShopItemService $siService)
    {
        $this->siService = $siService;
    }

    public function getItems(Request $request)
    {
        $request->validate([
            'itemCount' => ['nullable', 'integer'],
            'siteId' => ['nullable', 'integer'],
        ]);

        try {
            return responseOkAPI($this->siService->getItems(
                $request->itemCount,
                $request->nameOnly,
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

    public function getItem(Request $request)
    {
        $request->validate([
            'shopItemId' => ['integer'],
            'siteId' => ['nullable', 'integer'],
        ]);

        try {
            return responseOkAPI($this->siService->getItem(
                $request->shopItemId,
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
