<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Http\Requests\UpdateFaqCategoryRequest;
use App\Models\FaqCategory;
use App\Services\FaqCategoryService;
use App\Services\EmbedPartsService;
use Exception;
use Illuminate\Http\Request;
use Log;

class FaqCategoryController extends Controller
{
    protected $fcService;

    public function __construct(FaqCategoryService $fcService)
    {
        $this->fcService = $fcService;
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

        $items = $this->fcService->list($validated);
        $columns = ['name' => '部署・役職'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (is_null($request->keyword)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.faq_category.index', compact(
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
        return view('embed_parts.faq_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqCategoryRequest $request)
    {
        $faqCategory = $this->fcService->store($request->validated());
        if ($faqCategory) {
            return redirect(route('faq_category.edit', ['faq_category' => $faqCategory]))->with('success', 'よくある質問カテゴリーを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'よくある質問カテゴリーを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqCategory $faqCategory)
    {
        return view('embed_parts.faq_category.edit', compact('faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        try {
            $faqCategory->update($request->validated());
            return redirect(route('faq_category.edit', ['faq_category' => $faqCategory]))->with('success', '部署・組織を変更しました');
        } catch (Exception $e) {
            Log::debug($e);
            return redirect()->back()->withInput()->with('error', '部署・組織を変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faq_category)
    {
        if ($faq_category->delete()) {
            return redirect()->back()->withInput()->with('success', 'よくある質問カテゴリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'よくある質問カテゴリーを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->fcService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '部署・役職を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', '部署・役職を一括削除できませんでした');
            }
        }
    }
}
