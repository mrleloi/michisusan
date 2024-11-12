<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeforeAfterCategoryRequest;
use App\Http\Requests\UpdateBeforeAfterCategoryRequest;
use App\Models\BeforeAfterCategory;
use App\Services\BeforeAfterCategoryService;
use App\Services\EmbedPartsService;
use Exception;
use Illuminate\Http\Request;

class BeforeAfterCategoryController extends Controller
{
    protected $bacService;

    public function __construct(BeforeAfterCategoryService $bacService)
    {
        $this->bacService = $bacService;
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

        $items = $this->bacService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable', 'sortable'];

        return view('embed_parts.before_after_category.index', compact(
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
        return view('embed_parts.before_after_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeforeAfterCategoryRequest $request)
    {
        $beforeAfterCategory = $this->bacService->store($request->all());
        if ($beforeAfterCategory) {
            return redirect(route('before_after_category.edit', ['before_after_category' => $beforeAfterCategory]))->with('success', 'ビフォーアフターカテゴリーを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターカテゴリーを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeforeAfterCategory $beforeAfterCategory)
    {
        return view('embed_parts.before_after_category.edit', compact(
            'beforeAfterCategory',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeforeAfterCategoryRequest $request, BeforeAfterCategory $beforeAfterCategory)
    {
        try {
            $beforeAfterCategory->update($request->all());
            return redirect(route('before_after_category.edit', ['before_after_category' => $beforeAfterCategory]))->with('success', 'ビフォーアフターカテゴリーを変更しました');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターカテゴリーを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeforeAfterCategory $beforeAfterCategory)
    {
        if ($beforeAfterCategory->delete()) {
            return redirect()->back()->withInput()->with('success', 'ビフォーアフターカテゴリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフターカテゴリーを削除できませんでした');
        }
    }
}
