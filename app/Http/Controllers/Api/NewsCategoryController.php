<?php
// kiai_loi.le 2024.09.20 feature/07_kiai_latest_news_categories add start
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCategories\ChangeOrderNewsCategoryRequest;
use App\Models\NewsCategory;
use App\Services\NewsCategoryService;
use App\Http\Requests\NewsArticles\UpdateNewsArticleRequest;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    protected $newsCategoriesService;
    protected $newsCategoriesTranslateService;

    public function __construct(
        NewsCategoryService $newsCategoriesService,
    ) {
        $this->newsCategoriesService = $newsCategoriesService;
    }

    public function changeOrder(ChangeOrderNewsCategoryRequest $request) {
        try {
            $validatedData = $request->validated();

            $result = $this->newsCategoriesService->reorderCategories($validatedData);

            if ($result) {
                return responseOkAPI();
            }
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
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
// kiai_loi.le 2024.09.20 feature/07_kiai_latest_news_categories add end
