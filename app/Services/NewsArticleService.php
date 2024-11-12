<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Services;

use App\Models\NewsArticle;
use App\Models\NewsSetting;
use App\Models\NewsTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsArticleService
{
    protected $subnavigationService;

    public function __construct(NewsSubnavigationService $subnavigationService)
    {
        $this->subnavigationService = $subnavigationService;
    }

    public function findArticleById($id)
    {
        return NewsArticle::query()
            ->with([
                'categories',
                'tags',
                'sns',
                'template'
            ])
            ->where('id', $id)
            ->first();
    }

    public function getAllArticles($request)
    {
        $query = NewsArticle::query()
            ->with(['categories', 'tags', 'sns'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('news_article_category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('news_categories.id', $request->news_article_category_id);
            });
        }

        $perPage = $request->input('news_article_max_view', 10);

        return $query->paginate($perPage);
    }

    public function createArticle(array $data)
    {
        return DB::transaction(function () use ($data) {
            $newsArticle = NewsArticle::create($data);

            $this->syncTags($newsArticle, $data['tags'] ?? []);
            $this->syncSns($newsArticle, $data['sns'] ?? []);
            $this->syncCategories($newsArticle, $data['categories'] ?? []);
//            $this->handleTemplateCreation($newsArticle, $data);

            return $newsArticle;
        });
    }

    public function updateArticle(NewsArticle $newsArticle, array $data)
    {
        return DB::transaction(function () use ($newsArticle, $data) {
            $newsArticle->update($data);

            $this->syncTags($newsArticle, $data['tags'] ?? [], $data);
            $this->syncSns($newsArticle, $data['sns'] ?? [], $data);
            $this->syncCategories($newsArticle, $data['categories'] ?? [], $data);
//            $this->handleTemplateUpdate($newsArticle, $data);

            return $newsArticle;
        });
    }

    private function syncTags(NewsArticle $newsArticle, array $tags = [], $data = [])
    {
        $newsArticle->tags()->delete();

        foreach ($tags as $tag) {
            $newsArticle->tags()->create([
                'name' => $tag,
                'site_id' => $newsArticle->site_id,
                'news_article_id' => $data['news_article_id']?? null,
            ]);
        }
    }

    private function syncSns(NewsArticle $newsArticle, array $snsIds = [], $data = [])
    {
        $currentSnsIds = $newsArticle->sns->pluck('id')->toArray();
        $attachIds = array_diff($snsIds, $currentSnsIds);
        $detachIds = array_diff($currentSnsIds, $snsIds);

        $newsArticle->sns()->attach($attachIds, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newsArticle->sns()->detach($detachIds);
    }

    private function syncCategories(NewsArticle $newsArticle,  array $categoryIds = [], $data = [])
    {
        $currentCategoryIds = $newsArticle->categories->pluck('id')->toArray();
        $attachIds = array_diff($categoryIds, $currentCategoryIds);
        $detachIds = array_diff($currentCategoryIds, $categoryIds);

        $newsArticle->categories()->attach($attachIds, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newsArticle->categories()->detach($detachIds);
    }

    private function handleTemplateCreation(NewsArticle $newsArticle, array $data)
    {
        if (isset($data['is_template']) && $data['is_template']) {
            $this->createTemplate($newsArticle, $data);
        }
    }

    private function handleTemplateUpdate(NewsArticle $newsArticle, array $data)
    {
        $existingTemplate = NewsTemplate::where('article_id', $newsArticle->id)->first();

        if (isset($data['is_template']) && $data['is_template']) {
            if ($existingTemplate) {
                $this->updateTemplate($existingTemplate, $data);
            } else {
                $this->createTemplate($newsArticle, $data);
            }
        } else {
            $this->removeTemplateIfExists($newsArticle);
        }
    }

    private function createTemplate(NewsArticle $newsArticle, array $data)
    {
        NewsTemplate::create([
            'site_id' => $newsArticle->site_id,
            'article_id' => $newsArticle->id,
            'name' => $data['title'],
            'is_active' => true,
        ]);
    }

    private function updateTemplate(NewsTemplate $template, array $data)
    {
        $template->update([
            'name' => $data['title'],
        ]);
    }

    private function removeTemplateIfExists(NewsArticle $newsArticle)
    {
        NewsTemplate::where('article_id', $newsArticle->id)->delete();
    }

    public function deleteArticle(NewsArticle $newsArticle)
    {
        try {
            $result = DB::transaction(function () use ($newsArticle) {
                // Delete related tags
                $newsArticle->tags()->delete();

                // Delete related SNS associations
                $newsArticle->sns()->detach();

                // Delete related category associations
                $newsArticle->categories()->detach();

                // Delete related template
                NewsTemplate::where('article_id', $newsArticle->id)->delete();

                // Delete the article itself
                $articleDeleted = $newsArticle->delete();

                if (!$articleDeleted) {
                    throw new \Exception("Failed to delete article ID: " . $newsArticle->id);
                }

                return true;
            });

            return $result;
        } catch (\Exception $e) {
            Log::error("Exception occurred while deleting article ID: " . $newsArticle->id . ". Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function bulkDeleteArticles(array $articleIds)
    {

        try {
            $result = DB::transaction(function () use ($articleIds) {
                $articles = NewsArticle::whereIn('id', $articleIds)->get();

                foreach ($articles as $article) {
                    // Delete related tags
                    $article->tags()->delete();

                    // Delete related SNS associations
                    $article->sns()->detach();

                    // Delete related category associations
                    $article->categories()->detach();

                    // Delete related template
                    NewsTemplate::where('article_id', $article->id)->delete();

                    // Delete the article itself
                    $articleDeleted = $article->delete();

                    if (!$articleDeleted) {
                        throw new \Exception("Failed to delete article ID: " . $article->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for article IDs: " . implode(', ', $articleIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
