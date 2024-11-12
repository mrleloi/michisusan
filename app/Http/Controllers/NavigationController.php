<?php

namespace App\Http\Controllers;

use App\Http\Requests\Redirects\UpdateRedirectRequest;
use App\Http\Requests\Subnavigations\StoreSubnavigationRequest;
use App\Models\Fonts;
use App\Models\FontWeight;
use App\Models\SiteRedirectRecord;
use App\Models\Subnavigation;
use App\Services\EmbedPartsService;
use App\Services\NavigationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
        ]);

        $items = $this->navigationService->list($validated);
        $columns = ['name' => 'サブナビゲーション名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;

        return view('navigations.index', compact('items', 'columns', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $startPages = EmbedPartsService::START_PAGES;
        $fonts = Fonts::query()->get();
        $fontWeights = FontWeight::query()->get();
        $hoverAnimations = EmbedPartsService::ANIMATIONS;

        return view('navigations.create', compact('startPages', 'fonts', 'fontWeights', 'hoverAnimations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubnavigationRequest $request)
    {
        $validatedData = $request->validated();

        if (!Auth::check()) {
            $validatedData['site_id'] = 1;
        }
        $sub = $this->navigationService->store($validatedData);
        if ($sub) {
            return redirect(route('navigations.index'))->with('success', '追加されたナビゲーション');
        } else {
            return redirect()->back()->withInput()->with('error', 'ナビゲーションを追加できません');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subnavigation $navigation)
    {
        $subSpMenus = $navigation->subnavigationSmartphoneMenus;
        $startPages = EmbedPartsService::START_PAGES;
        $fonts = Fonts::query()->get();
        $fontWeights = FontWeight::query()->get();
        $hoverAnimations = EmbedPartsService::ANIMATIONS;

        return view('navigations.edit', compact('navigation','subSpMenus', 'startPages', 'fonts', 'fontWeights', 'hoverAnimations'))->with('success', '編集を完了しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubnavigationRequest $request, Subnavigation $navigation)
    {
        $dataUpdate = $request->validated();

        if (!Auth::check()) {
            $dataUpdate['site_id'] = 1;
        }
        $subUpdate = $this->navigationService->update($dataUpdate, $navigation);

        if ($subUpdate) {
            return redirect(route('navigations.index'))->with('success', '動画カテゴリーが変わりました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビデオカテゴリを変更できません');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Subnavigation $navigation)
    {
        if ($navigation->delete()) {
            return redirect()->back()->withInput()->with('success', '削除されたナビゲーション');
        } else {
            return redirect()->back()->withInput()->with('error', 'ナビゲーションを削除できません');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->navigationService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'ナビゲーションが一括削除されました');
            } else {
                return redirect()->back()->withInput()->with('error', '一括ナビゲーションを削除できません');
            }
        }
    }


}
