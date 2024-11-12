<?php
namespace App\Services;

use App\Models\NewsCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TagService
{
    public function getAllTags()
    {
        return Tag::query()->orderBy('order')->get();
    }

    public function changeOrder($from, $to)
    {
        return DB::transaction(function () use ($from, $to) {
            if ($from != $to) {
                $fromObj = Tag::where('order', $from)->first();
                $toObj = Tag::where('order', $to)->first();

                if (!$fromObj || !$toObj || $fromObj->id == $toObj->id  || $fromObj->site_id != $toObj->site_id) {
                    return false;
                }
                $sof = $fromObj->order;
                $fromObj->order = $toObj->order;
                $toObj->order = $sof;

                $fromObj->save();
                $toObj->save();

                return $fromObj;
            }
            return false;
        });
    }

    public function reorderTags(array $data): bool
    {
        try {
            DB::beginTransaction();
            $items = $data['items'];

            usort($items, function($a, $b) {
                return $a['index'] - $b['index'];
            });

            $currentOrders = array_column($items, 'order');
            sort($currentOrders);

            foreach ($items as $index => $item) {
                Tag::where('id', $item['id'])->update(['order' => $currentOrders[$index]]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('エラーが発生しました。システムの管理者に連絡してください。: ' . $e->getMessage());
            return false;
        }
    }

    public function findTagById($id)
    {
        return Tag::query()
            ->with([
                'pages'
            ])
            ->where('id', $id)
            ->first();
    }

    public function getAllTagsWithPaging($request)
    {
        $query = Tag::ordered();

        if ($request->filled('tag_keyword')) {
            $keyword = '%' . $request->tag_keyword . '%';
            $query->where('name', 'like', $keyword);
        }

        $perPage = $request->input('tag_max_view', 10);

        return $query->paginate($perPage);
    }

    public function createTag(array $data)
    {
        $tag = Tag::create($data);
        return $tag;
    }

    public function updateTag(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        try {
            return DB::transaction(function () use ($tag) {
                // Delete related tags associations
                $tag->newsTags()->delete();
                $tag->blogsTags()->delete();

                // Delete the category itself
                $tagDeleted = $tag->delete();

                if (!$tagDeleted) {
                    throw new \Exception("Failed to delete tag ID: " . $tag->id);
                }

                return true;
            });
        } catch (\Exception $e) {
            Log::error("Exception occurred while deleting category ID: " . $tag->id . ". Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function bulkDeleteTags(array $tagIds)
    {
        try {
            $result = DB::transaction(function () use ($tagIds) {
                $tags = Tag::whereIn('id', $tagIds)->get();

                foreach ($tags as $tag) {
                    $tag->newsTags()->delete();
                    $tag->blogsTags()->delete();

                    $tagDeleted = $tag->delete();

                    if (!$tagDeleted) {
                        throw new \Exception("Failed to delete category ID: " . $tag->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for category IDs: " . implode(', ', $tagIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
