<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecruitingCategoryService;
use App\Services\RecruitingService;

class RecruitingController extends Controller
{
    protected $recruitingService;
    protected $rcService;

    public function __construct(RecruitingService $recruitingService, RecruitingCategoryService $rcService)
    {
        $this->recruitingService = $recruitingService;
        $this->rcService = $rcService;
    }

    public function getCategories()
    {
        try {
            return responseOkAPI($this->rcService->getAll());
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function getItemsByCategory()
    {
        try {
            return responseOkAPI($this->recruitingService->getItemsByCategory());
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
