<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogsPosts\BlogsPostIndexFilterRequest;
use App\Http\Requests\BlogsPosts\StoreBlogsPostRequest;
use App\Http\Requests\BlogsPosts\StoreBlogsSimpleRequest;
use App\Http\Requests\BlogsPosts\UpdateBlogsPostRequest;
use App\Http\Resources\BlogsPosts\BlogsPostCollection;
use App\Http\Resources\BlogsPosts\BlogsPostUpdateResource;
use App\Http\Resources\BlogsCategories\BlogsCategoryCollection;
use App\Models\BlogsPost;
use App\Models\Tag;
use App\Services\BlogsPostService;
use App\Services\BlogsCategoryService;
use App\Services\BlogsSnsService;
use App\Services\BlogsSubnavigationService;
use App\Services\BlogsTagService;
use App\Services\NewsSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsPostController extends Controller
{
    protected $blogsPostService;
    protected $blogsCategoryService;
    protected $blogsTagService;
    protected $blogsSubnavigationService;
    protected $blogsSnsService;

    public function __construct(
        BlogsPostService $blogsPostService,
        BlogsCategoryService $blogsCategoryService,
        BlogsTagService $blogsTagService,
        BlogsSubnavigationService $blogsSubnavigationService,
        BlogsSnsService $blogsSnsService,
        NewsSettingService $newsSettingService
    ) {
        $this->blogsPostService = $blogsPostService;
        $this->blogsCategoryService = $blogsCategoryService;
        $this->blogsTagService = $blogsTagService;
        $this->blogsSubnavigationService = $blogsSubnavigationService;
        $this->blogsSnsService = $blogsSnsService;
        $this->newsSettingService = $newsSettingService;
    }

    public function index(BlogsPostIndexFilterRequest $request) {
        // save filters to session
        if ($request->isMethod('post')) {
            $request->session()->put('blogs_post_filters', $request->except('_token'));
            return redirect()->route('blogs_posts.index');
        }
        $filters = $request->session()->get('blogs_post_filters', []);
        $mergedRequest = $request->merge($filters);

        // Get articles with filters applied
        $items = $this->blogsPostService->getAllPosts($mergedRequest);
        $categories = $this->blogsCategoryService->getAllCategories();

        return view('blogs_posts.list', [
            'items' => new BlogsPostCollection($items),
            'categories' => new BlogsCategoryCollection($categories),
            'maxViewOptions' => config('views.blogs_posts.max_view_options'),
            'columns' => config('views.blogs_posts.columns'),
        ]);
    }

    public function create(Request $request)
    {
        $tags = $this->blogsTagService->getRecentTags();
        $tags = $tags->map(function ($tag) {
            $tagInfo = Tag::find($tag->tag_id);
            $tag->name = $tagInfo->name;

            return $tag;
        });
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();
        $snses = $this->blogsSnsService->getAllSns();
        $categories = $this->blogsCategoryService->getAllCategories();
        return view('blogs_posts.create', [
            'path' => route('blogs_posts.store'),
            'tags' => $tags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
        ]);
    }

    public function store(StoreBlogsPostRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->blogsPostService->createPost($validatedData);

            if ($result) {
                return redirect()->route('blogs_posts.index')->with('success', '新着情報が正常に作成されました。');
            }
            return redirect()->route('blogs_posts.index')->with('error', '新着情報の作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の作成中にエラーが発生しました。');
        }
    }

    public function edit(BlogsPost $blogsPost)
    {
        $tags = $this->blogsTagService->getRecentTags();
        $tags = $tags->map(function ($tag) {
            $tagInfo = Tag::find($tag->tag_id);
            $tag->name = $tagInfo->name;

            return $tag;
        });
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();
        $snses = $this->blogsSnsService->getAllSns();
        $categories = $this->blogsCategoryService->getAllCategories();

        if ($blogsPost->is_simple == BlogsPost::IS_SIMPLE_YES) {
            return redirect()->route('blogs_simple.edit', ['blogsPost' => $blogsPost['id']]);
        }

        return view('blogs_posts.edit', [
            'path' => route('blogs_posts.update', ['blogsPost' => $blogsPost['id']]),
            'blogsPost' => new BlogsPostUpdateResource($blogsPost),
            'tags' => $tags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
        ]);
    }

    public function editBlogSimple(BlogsPost $blogsPost)
    {
        $tags = $this->blogsTagService->getRecentTags();
        $tags = $tags->map(function ($tag) {
            $tagInfo = Tag::find($tag->tag_id);
            $tag->name = $tagInfo->name;

            return $tag;
        });
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();
        $snses = $this->blogsSnsService->getAllSns();
        $categories = $this->blogsCategoryService->getAllCategories();

        return view('blogs_posts.blog_simple_edit', [
            'path' => route('blogs_simple.update', ['blogsPost' => $blogsPost['id']]),
            'blogsPost' => new BlogsPostUpdateResource($blogsPost),
            'tags' => $tags,
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

            $result = $this->blogsPostService->updatePost($blogsPost, $validatedData);

            if ($result) {
                return redirect()->route('blogs_posts.index')->with('success', '新着情報が正常に更新されました。');
            }
            return redirect()->route('blogs_posts.index')->with('error', '新着情報の更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, BlogsPost $blogsPost)
    {
        try {
            $result = $this->blogsPostService->deletePost($blogsPost);

            if ($result) {
                return redirect()->route('blogs_posts.index')->with('success', '記事が正常に削除されました');
            }
            return redirect()->route('blogs_posts.index')->with('error', '記事の削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_posts.index')->with('error', '記事の削除中にエラーが発生しました');
        }
    }

    public function bulkDelete(Request $request)
    {
        $articleIds = $request->input('checks', []);

        if (empty($articleIds)) {
            return redirect()->route('blogs_posts.index')->with('error', '削除する記事が選択されていません');
        }

        try {
            $result = $this->blogsPostService->bulkDeletePosts($articleIds);

            if ($result) {
                return redirect()->route('blogs_posts.index')->with('success', '選択された記事が正常に削除されました');
            }
            return redirect()->route('blogs_posts.index')->with('error', '選択された記事の削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('blogs_posts.index')->with('error', '記事の削除中にエラーが発生しました');
        }
    }

    public function addBlogsSimple(Request $request)
    {
        $tags = $this->blogsTagService->getRecentTags();
        $tags = $tags->map(function ($tag) {
            $tagInfo = Tag::find($tag->tag_id);
            $tag->name = $tagInfo->name;

            return $tag;
        });
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();
        $snses = $this->blogsSnsService->getAllSns();
        $categories = $this->blogsCategoryService->getAllCategories();
        $designs = $this->newsSettingService->getAllDesigns();
        return view('blogs_posts.blog_simple', [
            'path' => route('blogs_simple.store'),
            'tags' => $tags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
            'designs' => $designs,
        ]);
    }

    public function storeBlogsSimple(StoreBlogsSimpleRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['is_simple'] = BlogsPost::IS_SIMPLE_YES;

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->blogsPostService->createPost($validatedData);

            if ($result) {
                return redirect()->route('blogs_posts.index')->with('success', 'ブログ記事が正常に作成されました。');
            }
            return redirect()->route('blogs_posts.index')->with('error', 'ブログ記事の作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'ブログ記事の作成中にエラーが発生しました。');
        }
    }
}
