<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCategories\NewsCategoryIndexFilterRequest;
use App\Http\Requests\NewsCategories\StoreNewsCategoryRequest;
use App\Http\Requests\NewsCategories\UpdateNewsCategoryRequest;
use App\Http\Resources\NewsCategories\NewsCategoryCollection;
use App\Http\Resources\NewsCategories\NewsCategoryUpdateResource;
use App\Models\NewsCategory;
use App\Services\NewsCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsCategoryController extends Controller
{
    protected $newsCategoryService;

    public function __construct(
        NewsCategoryService $newsCategoryService,
    ) {
        $this->newsCategoryService = $newsCategoryService;
    }

    public function index(NewsCategoryIndexFilterRequest $request) {
        // save filters to session
        if ($request->isMethod('post')) {
            $request->session()->put('news_category_filters', $request->except('_token'));
            return redirect()->route('news_categories.index');
        }
        $filters = $request->session()->get('news_category_filters', []);
        $mergedRequest = $request->merge($filters);

        // Get articles with filters applied
        $items = $this->newsCategoryService->getAllCategoriesWithPaging($mergedRequest);

        // Temporary disable feature sortable after searching
        $disableSortable = false;
        if ($mergedRequest->filled('news_category_keyword')) {
            $disableSortable = true;
        }

        return view('news_categories.list', [
            'items' => new NewsCategoryCollection($items),
            'maxViewOptions' => config('views.news_categories.max_view_options'),
            'columns' => config('views.news_categories.columns'),
            'disableSortable' => $disableSortable,
        ]);
    }

    public function create(Request $request)
    {
        $pages = $this->newsCategoryService->getAllPages();
        return view('news_categories.create', [
            'path' => route('news_categories.store'),
            'pages' => $pages,
        ]);
    }

    public function store(StoreNewsCategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->newsCategoryService->createCategory($validatedData);

            if ($result) {
                return redirect()->route('news_categories.index')->with('success', 'カテゴリが正常に作成されました。');
            }
            return redirect()->route('news_categories.index')->with('error', 'カテゴリの作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'カテゴリの作成中にエラーが発生しました。');
        }
    }

    public function edit(NewsCategory $newsCategory)
    {
        $pages = $this->newsCategoryService->getAllPages();
        return view('news_categories.edit', [
            'path' => route('news_categories.update', ['newsCategory' => $newsCategory['id']]),
            'newsCategory' => new NewsCategoryUpdateResource($newsCategory),
            'pages' => $pages,
        ]);
    }

    public function update(UpdateNewsCategoryRequest $request, NewsCategory $newsCategory)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->newsCategoryService->updateArticle($newsCategory, $validatedData);

            if ($result) {
                return redirect()->route('news_categories.index')->with('success', 'カテゴリが正常に更新されました。');
            }
            return redirect()->route('news_categories.index')->with('error', 'カテゴリの更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'カテゴリの更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, NewsCategory $newsCategory)
    {
        try {
            $result = $this->newsCategoryService->deleteCategory($newsCategory);

            if ($result) {
                return redirect()->route('news_categories.index')->with('success', 'カテゴリが正常に削除されました');
            }
            return redirect()->route('news_categories.index')->with('error', 'カテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('news_categories.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }

    public function bulkDelete(Request $request)
    {
        $articleIds = $request->input('checks', []);

        if (empty($articleIds)) {
            return redirect()->route('news_categories.index')->with('error', '削除する記事が選択されていません');
        }

        try {
            $result = $this->newsCategoryService->bulkDeleteCategories($articleIds);

            if ($result) {
                return redirect()->route('news_categories.index')->with('success', '選択されたカテゴリが正常に削除されました');
            }
            return redirect()->route('news_categories.index')->with('error', '選択されたカテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('news_categories.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }
}
