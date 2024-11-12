<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Services;

use App\Models\BlogsCategory;
use App\Models\BlogsSetting;
use App\Models\BlogsTemplate;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogsCategoryService
{
    public function getAllPages()
    {
        $fakeData = [
            (object)[
                'id' => 1,
                'text' => 'HOME',
                'url' => '/',
                'description' => 'トップ',
                'isPublic' => true
            ],
            (object)[
                'id' => 2,
                'text' => 'サービス内容',
                'url' => 'blogs',
                'description' => '新着情報',
                'isPublic' => true
            ],
        ];
        return $fakeData;
    }

    public function getAllCategories()
    {
        return BlogsCategory::query()->orderBy('order')->get();
    }

    public function changeOrder($from, $to)
    {
        return DB::transaction(function () use ($from, $to) {
            if ($from != $to) {
                $fromObj = BlogsCategory::where('order', $from)->first();
                $toObj = BlogsCategory::where('order', $to)->first();

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

    public function reorderCategories(array $data): bool
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
                BlogsCategory::where('id', $item['id'])->update(['order' => $currentOrders[$index]]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('エラーが発生しました。システムの管理者に連絡してください。: ' . $e->getMessage());
            return false;
        }
    }

    public function findCategoryById($id)
    {
        return BlogsCategory::query()
            ->with([
                'pages'
            ])
            ->where('id', $id)
            ->first();
    }

    public function getAllCategoriesWithPaging($request)
    {
        $query = BlogsCategory::ordered();

        if ($request->filled('blogs_category_keyword')) {
            $keyword = '%' . $request->blogs_category_keyword . '%';
            $query->where('name', 'like', $keyword);
        }

        $perPage = $request->input('blogs_category_max_view', 10);

        return $query->paginate($perPage);
    }

    public function updateArticle(BlogsCategory $blogsCategory, array $data)
    {
        $blogsCategory->update($data);
        return $blogsCategory;
    }

    public function createCategory(array $data)
    {
        $blogsCategory = BlogsCategory::create($data);
        return $blogsCategory;
    }

    public function updatePost(BlogsCategory $blogsCategory, array $data)
    {
        $blogsCategory->update($data);
        return $blogsCategory;
    }

    public function deleteCategory(BlogsCategory $blogsCategory)
    {
        try {
            $result = DB::transaction(function () use ($blogsCategory) {
                // Delete related posts associations
                $blogsCategory->posts()->detach();

                // Delete the category itself
                $categoryDeleted = $blogsCategory->delete();

                if (!$categoryDeleted) {
                    throw new \Exception("Failed to delete category ID: " . $blogsCategory->id);
                }

                return true;
            });

            return $result;
        } catch (\Exception $e) {
            Log::error("Exception occurred while deleting category ID: " . $blogsCategory->id . ". Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function bulkDeleteCategories(array $categoriesIds)
    {
        try {
            $result = DB::transaction(function () use ($categoriesIds) {
                $categories = BlogsCategory::whereIn('id', $categoriesIds)->get();

                foreach ($categories as $category) {
                    // Delete related posts associations
                    $category->posts()->detach();

                    // Delete the category itself
                    $categoryDeleted = $category->delete();

                    if (!$categoryDeleted) {
                        throw new \Exception("Failed to delete category ID: " . $category->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for category IDs: " . implode(', ', $categoriesIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end