<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Services\EmbedPartsService;
use App\Services\MenuItemService;
use Exception;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    protected $miService;

    public function __construct(MenuItemService $miService)
    {
        $this->miService = $miService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'category_id' => ['integer', 'nullable'],
            'visible' => ['integer', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->miService->list($validated);
        $columns = ['name' => 'メニュー名', 'menu_categories.0.name' => 'カテゴリ名', 'price:comma_num' => '金額'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $categoryOptions = $this->miService->getCategoryOfCurrentSite(true);
        $visibleOptions = array_merge([['key' => '', 'label' => '表示・非表示']], EmbedPartsService::VISIBLE_OPTIONS);
        $listActions = ['delete', 'edit', 'selectable'];

        if (!isset($request->category_id) && !isset($request->visible)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.menu_item.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'categoryOptions',
            'visibleOptions',
            'listActions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuCategories = $this->miService->getCategoryOfCurrentSite();
        $taxTypes = $this->miService->getTaxTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        return view('embed_parts.menu_item.create', compact(
            'menuCategories',
            'taxTypes',
            'visibleOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request)
    {
        $menuItem = $this->miService->store($request->all());
        if ($menuItem) {
            return redirect(route('menu_item.edit', ['menu_item' => $menuItem]))->with('success', 'メニューを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'メニューを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $menuCategories = $this->miService->getCategoryOfCurrentSite();
        $taxTypes = $this->miService->getTaxTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $selectedMenuCategories = $menuItem->menuCategories->pluck('id')->toArray();

        return view('embed_parts.menu_item.edit', compact(
            'menuCategories',
            'taxTypes',
            'visibleOptions',
            'menuItem',
            'selectedMenuCategories',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
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

        try {
            $menuItem->update($request->all());
            $this->miService->syncCategory($menuItem, $request->menu_category_id);
            return redirect(route('menu_item.edit', ['menu_item' => $menuItem]))->with('success', 'メニューを変更しました');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'メニューを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->menuCategories()->detach();
        if ($menuItem->delete()) {
            return redirect()->back()->withInput()->with('success', 'メニューを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'メニューを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->miService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'メニューを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'メニューを一括削除できませんでした');
            }
        }
    }

    public function registCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['max:250'],
        ]);

        return response()->json($this->miService->registerCategory($validated));
    }
}
