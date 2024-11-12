<?php
namespace App\Services;

use App\Models\BlogsPost;
use App\Models\BlogsTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogsTemplateService
{
    public function getAllBlogsTemplateWithPaging($request)
    {
        $query = BlogsTemplate::query();

        if ($request->filled('blogs_template_keyword')) {
            $keyword = '%' . $request->blogs_template_keyword . '%';
            $query->where('name', 'like', $keyword);
        }

        $perPage = $request->input('blogs_template_max_view', 10);

        return $query->paginate($perPage);
    }

    public function getBlogsPost($blogsTemplate)
    {
        $postId = BlogsTemplate::find($blogsTemplate->id)?->post_id;
        $blogsPost = BlogsPost::find($postId);

        return $blogsPost;
    }

    public function updatePost(BlogsPost $blogsPost, array $data)
    {
        return DB::transaction(function () use ($blogsPost, $data) {
            $blogsPost = BlogsPost::create($data);

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
            $blogsPost->tags()->create([
                'name' => $tag,
                'site_id' => $blogsPost->site_id,
                'blogs_post_id' => $data['blogs_post_id']?? null,
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


    public function bulkDeleteCategories(array $blogTemplateIds)
    {
        try {
            $result = DB::transaction(function () use ($blogTemplateIds) {
                $blogTemplates = BlogsTemplate::whereIn('id', $blogTemplateIds)->get();

                foreach ($blogTemplates as $blogTemplate) {
                    // Delete the blog template
                    $blogTemplateDeleted = $blogTemplate->delete();

                    if (!$blogTemplateDeleted) {
                        throw new \Exception("Failed to delete category ID: " . $blogTemplate->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for category IDs: " . implode(', ', $blogTemplateIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
