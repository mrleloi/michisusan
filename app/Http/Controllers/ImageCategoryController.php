<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageCategoryRequest;
use App\Http\Requests\StoreShopItemRequest;
use App\Http\Requests\UpdateShopItemRequest;
use App\Models\ImageFileCategory;
use App\Models\ShopItem;
use App\Services\EmbedPartsService;
use App\Services\ImageCategoryService;
use App\Services\ShopItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImageCategoryController extends Controller
{
    protected $imageCategoryService;

    public function __construct(ImageCategoryService $imageCategoryService)
    {
        $this->imageCategoryService = $imageCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
            'keyword' => [],
        ]);

        $items = $this->imageCategoryService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;

        return view('image_categories.index', compact('items', 'columns', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('image_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageCategoryRequest $request)
    {
        $validatedData = $request->validated();

        if (!Auth::check()) {
            $validatedData['site_id'] = 1;
        }
        $imageCategory = $this->imageCategoryService->store($validatedData);
        if ($imageCategory) {
            return redirect(route('image_categories.index'))->with('success', '画像カテゴリを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', '画像カテゴリを追加できません');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageFileCategory $imageCategory)
    {
        return view('image_categories.edit', compact(
            'imageCategory'
        ))->with('success', '編集を完了しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreImageCategoryRequest $request, ImageFileCategory $imageCategory)
    {
        if ($imageCategory->update($request->validated())) {
            return redirect(route('image_categories.index'))->with('success', '画像カテゴリーを変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', '画像カテゴリを変更できません');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(ImageFileCategory $imageCategory)
    {
        $images = $imageCategory->imageFile;

        if ($images->count() > 0) {
            return redirect()->back()->withInput()->with('error', 'データが存在するカテゴリーは削除できません');
        }

        if ($imageCategory->delete()) {
            return redirect()->back()->withInput()->with('success', '画像カテゴリーが削除されました');
        } else {
            return redirect()->back()->withInput()->with('error', '画像カテゴリを削除できません');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            $listImages = [];
            foreach ($validated['checks'] as $check) {
                $images = $this->imageCategoryService->findById($check)->imageFile;
                $listImages = $images->merge($listImages);
            }

            if ($listImages->count() > 0) {
                return redirect()->back()->withInput()->with('error', 'データが存在するカテゴリーは削除できません');
            }

            if ($this->imageCategoryService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '画像カテゴリーが一括削除されました');
            } else {
                return redirect()->back()->withInput()->with('error', '画像カテゴリは一括削除できません');
            }
        }
    }
}
