<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoCategoryRequest;
use App\Models\ImageFileCategory;
use App\Models\VideoCategory;
use App\Services\EmbedPartsService;
use App\Services\VideoCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoCategoryController extends Controller
{
    protected $videoCategoryService;

    public function __construct(VideoCategoryService $videoCategoryService)
    {
        $this->videoCategoryService = $videoCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
            'keyword' => [],
        ]);

        $items = $this->videoCategoryService->list($validated);
        $columns = ['name' => 'カテゴリー名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;

        return view('video_categories.index', compact('items', 'columns', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('video_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoCategoryRequest $request)
    {
        $validatedData = $request->validated();

        if (!Auth::check()) {
            $validatedData['site_id'] = 1;
        }
        $videoCategory = $this->videoCategoryService->store($validatedData);
        if ($videoCategory) {
            return redirect(route('video_categories.index'))->with('success', '動画カテゴリーを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビデオカテゴリを追加できません');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoCategory $videoCategory)
    {
        return view('video_categories.edit', compact(
            'videoCategory'
        ))->with('success', '編集を完了しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreVideoCategoryRequest $request, VideoCategory $videoCategory)
    {
        if ($videoCategory->update($request->validated())) {
            return redirect(route('video_categories.index'))->with('success', '動画カテゴリーが変わりました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビデオカテゴリを変更できません');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(VideoCategory $videoCategory)
    {
        $videos = $videoCategory->video;

        if ($videos->count() > 0) {
            return redirect()->back()->withInput()->with('error', 'データが存在するカテゴリーは削除できません');
        }

        if ($videoCategory->delete()) {
            return redirect()->back()->withInput()->with('success', '動画カテゴリが削除されました');
        } else {
            return redirect()->back()->withInput()->with('error', '動画カテゴリを削除できません');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            $listVideos = [];
            foreach ($validated['checks'] as $check) {
                $videos = $this->videoCategoryService->findById($check)->video;
                $listVideos = $videos->merge($listVideos);
            }

            if ($listVideos->count() > 0) {
                return redirect()->back()->withInput()->with('error', 'データが存在するカテゴリーは削除できません');
            }

            if ($this->videoCategoryService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '動画カテゴリが一括削除されました');
            } else {
                return redirect()->back()->withInput()->with('error', '動画カテゴリは一括削除できません');
            }
        }
    }
}
