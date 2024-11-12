<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecruitingCategoryRequest;
use App\Http\Requests\UpdateRecruitingCategoryRequest;
use App\Models\RecruitingCategory;
use App\Services\EmbedPartsService;
use App\Services\RecruitingCategoryService;
use Illuminate\Http\Request;

class RecruitingCategoryController extends Controller
{
    protected $rcService;

    public function __construct(RecruitingCategoryService $rcService)
    {
        $this->rcService = $rcService;
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

        $items = $this->rcService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (!isset($request->keyword)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.recruiting_category.index', compact(
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

        return view('embed_parts.recruiting_category.create', compact('visibleOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecruitingCategoryRequest $request)
    {
        $recruitingCategory = $this->rcService->store($request->validated());
        if ($recruitingCategory) {
            return redirect()->route('recruiting_category.edit', ['recruiting_category' => $recruitingCategory])
                ->with('success', '求人情報カテゴリーを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報カテゴリーを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitingCategory $recruitingCategory)
    {
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.recruiting_category.edit', compact('recruitingCategory', 'visibleOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecruitingCategoryRequest $request, RecruitingCategory $RecruitingCategory)
    {
        $validated = $request->validated();
        if ($RecruitingCategory->update($validated)) {
            return redirect(route('recruiting_category.edit', array('recruiting_category' => $RecruitingCategory)))->with('success', '求人情報カテゴリーを変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報カテゴリーを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitingCategory $RecruitingCategory)
    {
        if ($RecruitingCategory->delete()) {
            return redirect()->back()->withInput()->with('success', '求人情報カテゴリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報カテゴリーを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->rcService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '求人情報カテゴリーを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', '求人情報カテゴリーを一括削除できませんでした');
            }
        }
    }
}
