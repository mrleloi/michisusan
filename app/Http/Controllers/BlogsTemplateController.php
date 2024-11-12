<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogsCategories\BlogsCategoryIndexFilterRequest;
use App\Http\Requests\BlogsPosts\StoreBlogsPostRequest;
use App\Http\Requests\BlogsPosts\UpdateBlogsPostRequest;
use App\Http\Requests\BlogsTemplates\BlogsTemplateIndexFilterRequest;
use App\Http\Resources\BlogsCategories\BlogsCategoryCollection;
use App\Http\Resources\BlogsPosts\BlogsPostUpdateResource;
use App\Http\Resources\BlogsTemplates\BlogsTemplateCollection;
use App\Models\BlogsPost;
use App\Models\BlogsTemplate;
use App\Services\BlogsCategoryService;
use App\Services\BlogsSnsService;
use App\Services\BlogsSubnavigationService;
use App\Services\BlogsTagService;
use App\Services\BlogsTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsTemplateController extends Controller
{
    protected $blogsTemplateService;
    protected $blogsCategoryService;
    protected $blogsTagService;
    protected $blogsSubnavigationService;
    protected $blogsSnsService;

    public function __construct(
        BlogsTemplateService $blogsTemplateService,
        BlogsCategoryService $blogsCategoryService,
        BlogsTagService $blogsTagService,
        BlogsSubnavigationService $blogsSubnavigationService,
        BlogsSnsService $blogsSnsService,
    ) {
        $this->blogsTemplateService = $blogsTemplateService;
        $this->blogsTagService = $blogsTagService;
        $this->blogsSubnavigationService = $blogsSubnavigationService;
        $this->blogsSnsService = $blogsSnsService;
        $this->blogsCategoryService = $blogsCategoryService;
    }

    public function index(BlogsTemplateIndexFilterRequest $request)
    {
        if ($request->isMethod('post')) {
            $request->session()->put('blogs_template_filters', $request->except('_token'));
            return redirect()->route('blogs_templates.index');
        }
        $filters = $request->session()->get('blogs_template_filters', []);
        $mergedRequest = $request->merge($filters);

        $items = $this->blogsTemplateService->getAllBlogsTemplateWithPaging($mergedRequest);
        $disableSortable = false;
        if ($mergedRequest->filled('blogs_template_keyword')) {
            $disableSortable = true;
        }

        return view('blogs_templates.list', [
            'items' => new BlogsTemplateCollection($items),
            'maxViewOptions' => config('views.blogs_templates.max_view_options'),
            'columns' => config('views.blogs_templates.columns'),
            'disableSortable' => $disableSortable,
        ]);
    }
    public function edit(BlogsTemplate $blogsTemplate)
    {
        $blogsPost = $this->blogsTemplateService->getBlogsPost($blogsTemplate);

        $blogTags = $this->blogsTagService->getRecentTags();
        $blogTags = $blogTags->map(function ($blogTag) {
            if ($blogTag->tag) {
                $blogTag->name = $blogTag->tag->name;
            }
            return $blogTag;
        });
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();
        $snses = $this->blogsSnsService->getAllSns();
        $categories = $this->blogsCategoryService->getAllCategories();

        if ($blogsPost->is_simple == BlogsPost::IS_SIMPLE_YES) {
            return view('blogs_templates.simple', [
                'path' => route('blogs_templates.update', $blogsPost->id),
                'blogsTemplate' => new BlogsPostUpdateResource($blogsPost),
                'tags' => $blogTags,
                'subnavigations' => $subnavigations,
                'snses' => $snses,
                'categories' => $categories,
            ]);
        }

        return view('blogs_templates.create', [
            'path' => route('blogs_templates.update', $blogsPost->id),
            'blogsTemplate' => new BlogsPostUpdateResource($blogsPost),
            'tags' => $blogTags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateBlogsPostRequest $request, BlogsPost $blogsPost)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->blogsTemplateService->updatePost($blogsPost, $validatedData);

            if ($result) {
                return redirect()->route('blogs_templates.index')->with('success', 'ブログ記事が正常に更新されました。');
            }
            return redirect()->route('blogs_templates.index')->with('error', 'ブログ記事の更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'ブログ記事の更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, BlogsTemplate $blogsTemplate)
    {
        try {
            $result = $this->blogsTemplateService->deleteCategory($blogsTemplate);

            if ($result) {
                return redirect()->route('blogs_templates.index')->with('success', 'カテゴリが正常に削除されました');
            }
            return redirect()->route('blogs_templates.index')->with('error', 'カテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_templates.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }

    public function bulkDelete(Request $request)
    {
        $blogsTemplateIds = $request->input('checks', []);

        if (empty($blogsTemplateIds)) {
            return redirect()->route('blogs_templates.index')->with('error', '削除する記事が選択されていません');
        }

        try {
            $result = $this->blogsTemplateService->bulkDeleteCategories($blogsTemplateIds);

            if ($result) {
                return redirect()->route('blogs_templates.index')->with('success', '選択されたカテゴリが正常に削除されました');
            }
            return redirect()->route('blogs_templates.index')->with('error', '選択されたカテゴリの削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_templates.index')->with('error', 'カテゴリの削除中にエラーが発生しました');
        }
    }
}
