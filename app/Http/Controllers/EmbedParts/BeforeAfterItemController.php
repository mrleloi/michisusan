<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeforeAfterItemRequest;
use App\Http\Requests\UpdateBeforeAfterItemRequest;
use App\Models\BeforeAfterItem;
use App\Services\BeforeAfterItemService;
use App\Services\EmbedPartsService;
use Exception;
use Illuminate\Http\Request;
use Log;

class BeforeAfterItemController extends Controller
{
    protected $baiService;

    public function __construct(BeforeAfterItemService $baiService)
    {
        $this->baiService = $baiService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['integer', 'nullable'],
            'per_page' => ['integer', 'nullable'],
            'visible' => ['boolean', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->baiService->list($validated);
        $columns = ['title' => 'タイトル', 'before_after_category.name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $categoryOptions = $this->baiService->getCategoryOfCurrentSite(true);
        $listActions = ['delete', 'edit', 'selectable'];
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        if (is_null($request->keyword) && is_null($request->category_id) && is_null($request->visible)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.before_after_item.index', compact(
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
        $beforeAfterCategories = $this->baiService->getCategoryOfCurrentSite();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        return view('embed_parts.before_after_item.create', compact(
            'beforeAfterCategories',
            'visibleOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeforeAfterItemRequest $request)
    {
        $beforeAfterItem = $this->baiService->store($request->all());
        if ($beforeAfterItem) {
            return redirect(route('beforeAfter_item.edit', ['beforeAfter_item' => $beforeAfterItem]))->with('success', 'ビフォーアフターを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeforeAfterItem $beforeAfterItem)
    {
        $beforeAfterCategories = $this->baiService->getCategoryOfCurrentSite();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.before_after_item.edit', compact(
            'beforeAfterCategories',
            'visibleOptions',
            'beforeAfterItem',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeforeAfterItemRequest $request, BeforeAfterItem $beforeAfterItem)
    {
        try {
            $beforeAfterItem->update($request->all());
            return redirect(route('before_after_item.edit', ['before_after_item' => $beforeAfterItem]))->with('success', 'ビフォーアフターを変更しました');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeforeAfterItem $beforeAfterItem)
    {
        if ($beforeAfterItem->delete()) {
            return redirect()->back()->withInput()->with('success', 'ビフォーアフターを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->baiService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'ビフォーアフターを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'ビフォーアフターを一括削除できませんでした');
            }
        }
    }

    public function registCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['max:250'],
        ]);

        return response()->json($this->baiService->registerCategory($validated));
    }
}
