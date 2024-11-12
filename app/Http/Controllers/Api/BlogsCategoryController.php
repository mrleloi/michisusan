<?php
// kiai_loi.le 2024.09.20 feature/07_kiai_latest_Blogs_categories add start
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogsCategories\ChangeOrderBlogsCategoryRequest;
use App\Models\BlogsCategory;
use App\Services\BlogsCategoryService;
use App\Http\Requests\BlogsArticles\UpdateBlogsArticleRequest;
use Illuminate\Http\Request;

class BlogsCategoryController extends Controller
{
    protected $blogsCategoriesService;
    protected $blogsCategoriesTranslateService;

    public function __construct(
        BlogsCategoryService $blogsCategoriesService,
    ) {
        $this->blogsCategoriesService = $blogsCategoriesService;
    }

    public function changeOrder(ChangeOrderBlogsCategoryRequest $request) {
        try {
            $validatedData = $request->validated();

            $result = $this->blogsCategoriesService->reorderCategories($validatedData);

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
// kiai_loi.le 2024.09.20 feature/07_kiai_latest_Blogs_categories add end
