<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqItemRequest;
use App\Http\Requests\UpdateFaqItemRequest;
use App\Models\FaqItem;
use App\Services\EmbedPartsService;
use App\Services\FaqItemService;
use Exception;
use Illuminate\Http\Request;
use Log;

class FaqItemController extends Controller
{
    protected $fiService;

    public function __construct(FaqItemService $fiService)
    {
        $this->fiService = $fiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'category_id' => ['exists:faq_categories,id', 'nullable'],
            'visible' => ['boolean', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->fiService->list($validated);
        $columns = ['question:htmlpreview' => '質問内容', 'faq_category.name' => 'カテゴリ名', 'visible:visible' => '表示'];
        $categoryOptions = $this->fiService->getCategoryOfCurrentSite(false);
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (is_null($request->visible) && is_null($request->category_id) && is_null($request->keyword)  ) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.faq_item.index', compact(
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
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $faqCategories = $this->fiService->getCategoryOfCurrentSite();

        return view('embed_parts.faq_item.create', compact(
            'faqCategories',
            'visibleOptions',
        ));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqItemRequest $request)
    {
        $faqItem = $this->fiService->store($request->all());
        if ($faqItem) {
            return redirect(route('faq_item.edit', ['faq_item' => $faqItem]))->with('success', 'よくある質問を追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'よくある質問を追加できませんでした');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqItem $faqItem)
    {
        $faqCategories = $this->fiService->getCategoryOfCurrentSite();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.faq_item.edit', compact(
            'faqItem',
            'faqCategories',
            'visibleOptions',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqItemRequest $request, FaqItem $faqItem)
    {
        $validated = $request->validated();

        try {
            $faqItem->update($validated);
            return redirect(route('faq_item.edit', ['faq_item' => $faqItem]))->with('success', 'メニューを変更しました');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'メニューを変更できませんでした');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqItem $faqItem)
    {
        if ($faqItem->delete()) {
            return redirect()->back()->withInput()->with('success', 'よくある質問を削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'よくある質問を削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->fiService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'よくある質問を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'よくある質問を一括削除できませんでした');
            }
        }
    }

    public function registCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['max:250'],
        ]);

        return response()->json($this->fiService->registerCategory($validated));
    }
}
