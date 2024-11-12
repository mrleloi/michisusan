<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuCategoryRequest;
use App\Http\Requests\UpdateMenuCategoryRequest;
use App\Models\MenuCategory;
use App\Services\EmbedPartsService;
use App\Services\MenuCategoryService;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    protected $mcService;

    public function __construct(MenuCategoryService $mcService)
    {
        $this->mcService = $mcService;
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

        $items = $this->mcService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (!isset($request->keyword)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.menu_category.index', compact(
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
        return view('embed_parts.menu_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuCategoryRequest $request)
    {
        $menuCategory = $this->mcService->store($request->all());
        if ($menuCategory) {
            return redirect(route('menu_category.edit', ['menu_category' => $menuCategory]))
                ->with('success', 'メニューカテゴリーを追加しました');
        } else {
            return redirect()->back()->with('error', 'メニューカテゴリーを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuCategory $menuCategory)
    {
        return view('embed_parts.menu_category.edit', compact('menuCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuCategoryRequest $request, MenuCategory $menuCategory)
    {
        $validated = $request->validated();

        if (isset($validated['image1_id_delete']) && $validated['image1_id_delete'] == 1) {
            $request['image1_id'] = null;
        }
        if (isset($validated['image2_id_delete']) && $validated['image2_id_delete'] == 1) {
            $request['image2_id'] = null;
        }
        if (isset($validated['image3_id_delete']) && $validated['image3_id_delete'] == 1) {
            $request['image3_id'] = null;
        }

        if ($menuCategory->update($request->all()) !== 0) {
            return redirect(route('menu_category.edit', ['menu_category' => $menuCategory]))->with('success', 'メニューカテゴリーを変更しました');
        } else {
            return redirect(route('menu_category.edit', ['menu_category' => $menuCategory]))->with('error', 'メニューカテゴリーを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuCategory $menuCategory)
    {
        if ($menuCategory->delete()) {
            return redirect()->back()->withInput()->with('success', 'メニューカテゴリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'メニューカテゴリーを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->mcService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'メニューカテゴリーを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'メニューカテゴリーを一括削除できませんでした');
            }
        }
    }
}
