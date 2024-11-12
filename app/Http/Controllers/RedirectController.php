<?php

namespace App\Http\Controllers;

use App\Http\Requests\Redirects\StoreRedirectRequest;
use App\Http\Requests\Redirects\UpdateRedirectRequest;
use App\Models\SiteRedirectRecord;
use App\Services\EmbedPartsService;
use App\Services\RedirectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    protected $redirectService;

    public function __construct(RedirectService $redirectService)
    {
        $this->redirectService = $redirectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
        ]);

        $items = $this->redirectService->list($validated);
        $columns = ['slug_source' => 'リダイレクト元', 'slug_target' => 'リダイレクト先', 'status_code' => 'ステータスコード'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;

        return view('redirects.index', compact('items', 'columns', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusOptions = EmbedPartsService::STATUS_CODES;

        return view('redirects.create', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRedirectRequest $request)
    {
        $validatedData = $request->validated();

        if (!Auth::check()) {
            $validatedData['site_id'] = 1;
        }
        $redirect = $this->redirectService->store($validatedData);
        if ($redirect) {
            return redirect(route('redirects.index'))->with('success', '追加されたナビゲーション');
        } else {
            return redirect()->back()->withInput()->with('error', 'ナビゲーションを追加できません');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteRedirectRecord $redirect)
    {
        $statusOptions = EmbedPartsService::STATUS_CODES;

        return view('redirects.edit', compact(
            'redirect',
            'statusOptions'
        ))->with('success', '編集を完了しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRedirectRequest $request, SiteRedirectRecord $redirect)
    {
        $dataUpdate = $request->validated();

        if ($redirect->status_code == SiteRedirectRecord::STATUS_CODE_302 && $dataUpdate['status_code'] == SiteRedirectRecord::STATUS_CODE_301) {
            $dataUpdate['redirect_start'] = null;
            $dataUpdate['redirect_end'] = null;
        }

        if ($redirect->update($dataUpdate)) {
            return redirect(route('redirects.index'))->with('success', '動画カテゴリーが変わりました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビデオカテゴリを変更できません');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(SiteRedirectRecord $redirect)
    {
        if ($redirect->delete()) {
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
            if ($this->redirectService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'ナビゲーションが一括削除されました');
            } else {
                return redirect()->back()->withInput()->with('error', '一括ナビゲーションを削除できません');
            }
        }
    }
}
