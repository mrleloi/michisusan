<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogsCategories\BlogsCategoryIndexFilterRequest;
use App\Http\Requests\BlogsCategories\StoreBlogsCategoryRequest;
use App\Http\Requests\BlogsCategories\UpdateBlogsCategoryRequest;
use App\Http\Resources\BlogsCategories\BlogsCategoryCollection;
use App\Http\Resources\BlogsCategories\BlogsCategoryUpdateResource;
use App\Models\BlogsCategory;
use App\Services\BlogsCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsCategoryController extends Controller
{
    protected $blogsCategoryService;

    public function __construct(
        BlogsCategoryService $blogsCategoryService,
    ) {
        $this->blogsCategoryService = $blogsCategoryService;
    }

    public function index(BlogsCategoryIndexFilterRequest $request) {
        // save filters to session
        if ($request->isMethod('post')) {
            $request->session()->put('blogs_category_filters', $request->except('_token'));
            return redirect()->route('blogs_categories.index');
        }
        $filters = $request->session()->get('blogs_category_filters', []);
        $mergedRequest = $request->merge($filters);

        // Get articles with filters applied
        $items = $this->blogsCategoryService->getAllCategoriesWithPaging($mergedRequest);

        // Temporary disable feature sortable after searching
        $disableSortable = false;
        if ($mergedRequest->filled('blogs_category_keyword')) {
            $disableSortable = true;
        }

        return view('blogs_categories.list', [
            'items' => new BlogsCategoryCollection($items),
            'maxViewOptions' => config('views.blogs_categories.max_view_options'),
            'columns' => config('views.blogs_categories.columns'),
            'disableSortable' => $disableSortable,
        ]);
    }

    public function create(Request $request)
    {
        $pages = $this->blogsCategoryService->getAllPages();
        return view('blogs_categories.create', [
            'path' => route('blogs_categories.store'),
            'pages' => $pages,
        ]);
    }

    public function store(StoreBlogsCategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->blogsCategoryService->createCategory($validatedData);

            if ($result) {
                return redirect()->route('blogs_categories.index')->with('success', 'カテゴリが正常に作成されました。');
            }
            return redirect()->route('blogs_categories.index')->with('error', 'カテゴリの作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'カテゴリの作成中にエラーが発生しました。');
        }
    }

    public function edit(BlogsCategory $blogsCategory)
    {
        $pages = $this->blogsCategoryService->getAllPages();
        return view('blogs_categories.edit', [
            'path' => route('blogs_categories.update', ['blogsCategory' => $blogsCategory['id']]),
            'blogsCategory' => new BlogsCategoryUpdateResource($blogsCategory),
            'pages' => $pages,
        ]);
    }

    public function update(UpdateBlogsCategoryRequest $request, BlogsCategory $blogsCategory)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->blogsCategoryService->updateArticle($blogsCategory, $validatedData);

            if ($result) {
                return redirect()->route('blogs_categories.index')->with('success', 'カテゴリが正常に更新されました。');
            }
            return redirect()->route('blogs_categories.index')->with('error', 'カテゴリの更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'カテゴリの更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, BlogsCategory $blogsCategory)
    {
        try {
            $result = $this->blogsCategoryService->deleteCategory($blogsCategory);

            if ($result) {
                return redirect()->route('blogs_categories.index')->with('success', 'カテゴリが正常に削除されました');
            }
            return redirect()->route('blogs_categories.index')->with('error', 'カテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_categories.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }

    public function bulkDelete(Request $request)
    {
        $articleIds = $request->input('checks', []);

        if (empty($articleIds)) {
            return redirect()->route('blogs_categories.index')->with('error', '削除する記事が選択されていません');
        }

        try {
            $result = $this->blogsCategoryService->bulkDeleteCategories($articleIds);

            if ($result) {
                return redirect()->route('blogs_categories.index')->with('success', '選択されたカテゴリが正常に削除されました');
            }
            return redirect()->route('blogs_categories.index')->with('error', '選択されたカテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_categories.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }
}
