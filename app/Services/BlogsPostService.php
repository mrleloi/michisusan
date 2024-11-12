<?php
namespace App\Services;

use App\Models\BlogsPost;
use App\Models\BlogsSetting;
use App\Models\BlogsTemplate;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogsPostService
{
    protected $subnavigationService;

    public function __construct(BlogsSubnavigationService $subnavigationService)
    {
        $this->subnavigationService = $subnavigationService;
    }

    public function findpostById($id)
    {
        return BlogsPost::query()
            ->with([
                'categories',
                'tags',
                'sns',
                'template'
            ])
            ->where('id', $id)
            ->first();
    }

    public function getAllPosts($request)
    {
        $query = BlogsPost::query()
            ->with(['categories', 'tags', 'sns'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('blogs_post_keyword')) {
            $keyword = '%' . $request->blogs_post_keyword . '%';
            $query->where('blogs_posts.title', 'like', $keyword);
        }

        if ($request->filled('blogs_post_category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('blogs_categories.id', $request->blogs_post_category_id);
            });
        }

        $publicStatus = $request->blogs_post_public_status;
        if ($request->blogs_post_public_status != BlogsPost::STATUS_PUBLIC_RESERVATION) {
            if ($request->filled('blogs_post_public_status')) {
                if ($publicStatus == BlogsPost::STATUS_PUBLISHED || $publicStatus == BlogsPost::STATUS_UNPUBLISHED) {
                    $query->where('publish_status', $publicStatus)->whereNull('published_at');
                }
            }
        } else {
            $query->where('publish_status', BlogsPost::STATUS_PUBLISHED)->whereNotNull('published_at');
        }

        $perPage = $request->input('blogs_post_max_view', 10);

        return $query->paginate($perPage);
    }

    public function createPost(array $data)
    {
        return DB::transaction(function () use ($data) {
            $blogsPost = BlogsPost::create($data);

            $this->syncTags($blogsPost, $data['tags'] ?? []);
            $this->syncSns($blogsPost, $data['sns'] ?? []);
            $this->syncCategories($blogsPost, $data['categories'] ?? []);
            $this->handleTemplateCreation($blogsPost, $data);

            return $blogsPost;
        });
    }

    public function updatePost(BlogsPost $blogsPost, array $data)
    {
        return DB::transaction(function () use ($blogsPost, $data) {
            $blogsPost->update($data);

            $this->syncTags($blogsPost, $data['tags'] ?? [], $data);
            $this->syncSns($blogsPost, $data['sns'] ?? [], $data);
            $this->syncCategories($blogsPost, $data['categories'] ?? [], $data);
            $this->handleTemplateUpdate($blogsPost, $data);

            return $blogsPost;
        });
    }

    private function syncTags(BlogsPost $blogsPost, array $tags = [], $data = [])
    {
        $blogsPost->tags()->delete();

        foreach ($tags as $tag) {
            $tagAdd = Tag::query()->firstOrCreate(['name' => $tag]);
            $blogsPost->tags()->create([
                'tag_id' => $tagAdd->id,
                'site_id' => $blogsPost->site_id,
                'blogs_post_id' => $blogsPost->id ?? null,
            ]);
        }
    }

    private function syncSns(BlogsPost $blogsPost, array $snsIds = [], $data = [])
    {
        $currentSnsIds = $blogsPost->sns->pluck('id')->toArray();
        $attachIds = array_diff($snsIds, $currentSnsIds);
        $detachIds = array_diff($currentSnsIds, $snsIds);

        $blogsPost->sns()->attach($attachIds, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $blogsPost->sns()->detach($detachIds);
    }

    private function syncCategories(BlogsPost $blogsPost, array $categoryIds = [], $data = [])
    {
        $currentCategoryIds = $blogsPost->categories->pluck('id')->toArray();
        $attachIds = array_diff($categoryIds, $currentCategoryIds);
        $detachIds = array_diff($currentCategoryIds, $categoryIds);

        $blogsPost->categories()->attach($attachIds, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $blogsPost->categories()->detach($detachIds);
    }

    private function handleTemplateCreation(BlogsPost $blogsPost, array $data)
    {
        if (isset($data['is_template']) && $data['is_template']) {
            $this->createTemplate($blogsPost, $data);
        }
    }

    private function handleTemplateUpdate(BlogsPost $blogsPost, array $data)
    {
        $existingTemplate = BlogsTemplate::where('post_id', $blogsPost->id)->first();

        if (isset($data['is_template']) && $data['is_template']) {
            if ($existingTemplate) {
                $this->updateTemplate($existingTemplate, $data);
            } else {
                $this->createTemplate($blogsPost, $data);
            }
        } else {
            $this->removeTemplateIfExists($blogsPost);
        }
    }

    private function createTemplate(BlogsPost $blogsPost, array $data)
    {
        BlogsTemplate::create([
            'site_id' => $blogsPost->site_id,
            'post_id' => $blogsPost->id,
            'name' => $data['title'],
            'is_active' => true,
        ]);
    }

    private function updateTemplate(BlogsTemplate $template, array $data)
    {
        $template->update([
            'name' => $data['title'],
        ]);
    }

    private function removeTemplateIfExists(BlogsPost $blogsPost)
    {
        BlogsTemplate::where('post_id', $blogsPost->id)->delete();
    }

    public function deletePost(BlogsPost $blogsPost)
    {
        try {
            $result = DB::transaction(function () use ($blogsPost) {
                // Delete related tags
                $blogsPost->tags()->delete();

                // Delete related SNS associations
                $blogsPost->sns()->detach();

                // Delete related category associations
                $blogsPost->categories()->detach();

                // Delete related template
                BlogsTemplate::where('post_id', $blogsPost->id)->delete();

                // Delete the post itself
                $postDeleted = $blogsPost->delete();

                if (!$postDeleted) {
                    throw new \Exception("Failed to delete post ID: " . $blogsPost->id);
                }

                return true;
            });

            return $result;
        } catch (\Exception $e) {
            Log::error("Exception occurred while deleting post ID: " . $blogsPost->id . ". Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function bulkDeletePosts(array $postIds)
    {
        try {
            $result = DB::transaction(function () use ($postIds) {
                $posts = BlogsPost::whereIn('id', $postIds)->get();

                foreach ($posts as $post) {
                    // Delete related tags
                    $post->tags()->delete();

                    // Delete related SNS associations
                    $post->sns()->detach();

                    // Delete related category associations
                    $post->categories()->detach();

                    // Delete related template
                    BlogsTemplate::where('post_id', $post->id)->delete();

                    // Delete the post itself
                    $postDeleted = $post->delete();

                    if (!$postDeleted) {
                        throw new \Exception("Failed to delete post ID: " . $post->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for post IDs: " . implode(', ', $postIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
