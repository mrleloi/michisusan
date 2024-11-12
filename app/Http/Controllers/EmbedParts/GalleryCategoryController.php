<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryCategoryRequest;
use App\Http\Requests\UpdateGalleryCategoryRequest;
use App\Models\GalleryCategory;
use App\Services\EmbedPartsService;
use App\Services\GalleryCategoryService;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    protected $gcService;

    public function __construct(GalleryCategoryService $gcService)
    {
        $this->gcService = $gcService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->gcService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (!isset($request->keyword)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.gallery_category.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'listActions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.gallery_category.create', compact('visibleOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryCategoryRequest $request)
    {
        $galleryCategory = $this->gcService->store($request->validated());
        if ($galleryCategory) {
            return redirect()->route('gallery_category.edit', ['gallery_category' => $galleryCategory])
                ->with('success', 'ギャラリーカテゴリーを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーカテゴリーを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryCategory $galleryCategory)
    {
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.gallery_category.edit', compact('galleryCategory', 'visibleOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryCategoryRequest $request, GalleryCategory $GalleryCategory)
    {
        $validated = $request->validated();
        if ($GalleryCategory->update($validated)) {
            return redirect(route('gallery_category.edit', array('gallery_category' => $GalleryCategory)))->with('success', 'ギャラリーカテゴリーを変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーカテゴリーを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryCategory $GalleryCategory)
    {
        if ($GalleryCategory->delete()) {
            return redirect()->back()->withInput()->with('success', 'ギャラリーカテゴリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーカテゴリーを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->gcService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'ギャラリーカテゴリーを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'ギャラリーカテゴリーを一括削除できませんでした');
            }
        }
    }
}
