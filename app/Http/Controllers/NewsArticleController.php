<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsArticles\NewsArticleIndexFilterRequest;
use App\Http\Requests\NewsArticles\StoreNewsArticleRequest;
use App\Http\Requests\NewsArticles\UpdateNewsArticleRequest;
use App\Http\Resources\NewsArticles\NewsArticleCollection;
use App\Http\Resources\NewsArticles\NewsArticleUpdateResource;
use App\Http\Resources\NewsCategories\NewsCategoryCollection;
use App\Models\NewsArticle;
use App\Services\NewsArticleService;
use App\Services\NewsCategoryService;
use App\Services\NewsSnsService;
use App\Services\NewsSubnavigationService;
use App\Services\NewsTagService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsArticleController extends Controller
{
    protected $newsArticleService;
    protected $newsCategoryService;
    protected $newsTagService;
    protected $newsSnsService;
    protected $tagService;

    public function __construct(
        NewsArticleService $newsArticleService,
        NewsCategoryService $newsCategoryService,
        NewsTagService $newsTagService,
        NewsSubnavigationService $newsSubnavigationService,
        NewsSnsService $newsSnsService,
        TagService $tagService
    ) {
        $this->newsArticleService = $newsArticleService;
        $this->newsCategoryService = $newsCategoryService;
        $this->newsTagService = $newsTagService;
        $this->newsSubnavigationService = $newsSubnavigationService;
        $this->newsSnsService = $newsSnsService;
        $this->tagService = $tagService;
    }

    public function index(NewsArticleIndexFilterRequest $request) {
        // save filters to session
        if ($request->isMethod('post')) {
            $request->session()->put('news_article_filters', $request->except('_token'));
            return redirect()->route('news_articles.index');
        }
        $filters = $request->session()->get('news_article_filters', []);
        $mergedRequest = $request->merge($filters);

        // Get articles with filters applied
        $items = $this->newsArticleService->getAllArticles($mergedRequest);
        $categories = $this->newsCategoryService->getAllCategories();

        return view('news_articles.list', [
            'items' => new NewsArticleCollection($items),
            'categories' => new NewsCategoryCollection($categories),
            'maxViewOptions' => config('views.news_articles.max_view_options'),
            'columns' => config('views.news_articles.columns'),
        ]);
    }

    public function create(Request $request)
    {
        $tags = $this->tagService->getAllTags();
        $subnavigations = $this->newsSubnavigationService->getAllSubNavigations();
        $snses = $this->newsSnsService->getAllSns();
        $categories = $this->newsCategoryService->getAllCategories();
        return view('news_articles.create', [
            'path' => route('news_articles.store'),
            'tags' => $tags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
        ]);
    }

    public function store(StoreNewsArticleRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->newsArticleService->createArticle($validatedData);

            if ($result) {
                return redirect()->route('news_articles.index')->with('success', '新着情報が正常に作成されました。');
            }
            return redirect()->route('news_articles.index')->with('error', '新着情報の作成中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の作成中にエラーが発生しました。');
        }
    }

    public function edit(NewsArticle $newsArticle)
    {
        $tags = $this->tagService->getAllTags();
        $subnavigations = $this->newsSubnavigationService->getAllSubNavigations();
        $snses = $this->newsSnsService->getAllSns();
        $categories = $this->newsCategoryService->getAllCategories();
        return view('news_articles.edit', [
            'path' => route('news_articles.update', ['newsArticle' => $newsArticle['id']]),
            'newsArticle' => new NewsArticleUpdateResource($newsArticle),
            'tags' => $tags,
            'subnavigations' => $subnavigations,
            'snses' => $snses,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateNewsArticleRequest $request, NewsArticle $newsArticle)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            }

            $result = $this->newsArticleService->updateArticle($newsArticle, $validatedData);

            if ($result) {
                return redirect()->route('news_articles.index')->with('success', '新着情報が正常に更新されました。');
            }
            return redirect()->route('news_articles.index')->with('error', '新着情報の更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の更新中にエラーが発生しました。');
        }
    }

    public function delete(Request $request, NewsArticle $newsArticle)
    {
        try {
            $result = $this->newsArticleService->deleteArticle($newsArticle);

            if ($result) {
                return redirect()->route('news_articles.index')->with('success', '記事が正常に削除されました');
            }
            return redirect()->route('news_articles.index')->with('error', '記事の削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('news_articles.index')->with('error', '記事の削除中にエラーが発生しました');
        }
    }

    public function bulkDelete(Request $request)
    {
        $articleIds = $request->input('checks', []);

        if (empty($articleIds)) {
            return redirect()->route('news_articles.index')->with('error', '削除する記事が選択されていません');
        }

        try {
            $result = $this->newsArticleService->bulkDeleteArticles($articleIds);

            if ($result) {
                return redirect()->route('news_articles.index')->with('success', '選択された記事が正常に削除されました');
            }
            return redirect()->route('news_articles.index')->with('error', '選択された記事の削除に失敗しました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('news_articles.index')->with('error', '記事の削除中にエラーが発生しました');
        }
    }
}
