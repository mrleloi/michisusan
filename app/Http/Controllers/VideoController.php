<?php

namespace App\Http\Controllers;

use App\Http\Requests\Videos\StoreVideoRequest;
use App\Models\ImageFile;
use App\Models\Video;
use App\Services\ImageFileService;
use App\Services\VideoService;
use Exception;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'video_category_id' => ['nullable', 'integer'],
        ]);

        $categoryId = $validated['video_category_id'] ?? null;

        $categoryList = $this->videoService->getCategories();

        $selectAllCategory = [
            'id' => null,
            'name' => 'カテゴリー 一覧'
        ];
        $categoryList->prepend((object) $selectAllCategory);

        $items = $this->videoService->list($validated);

        return view('videos.index', compact('items', 'categoryList', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryList = $this->videoService->getCategories();

        return view('videos.create', compact(
            'categoryList'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $file = $request->file('file');
        $categoryId = $request->input('video_category_id');
        try {
            $result = $this->videoService->upload($file, $categoryId);

            if ($result) {
                return redirect()->route('videos.index')->with('success', '追加を完了しました');
            }
        } catch (Exception $e) {
            return redirect()->route('videos.create')
                ->with('error', 'アップロードできませんでした');
        }
    }

    public function edit(Video $video)
    {
        $categoryList = $this->videoService->getCategories();
        $path = route('videos.update', ['video' => $video->id]);

        return view('videos.edit', compact(
            'video','categoryList','path'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'video_category_id' => 'exists:video_categories,id',
        ]);

        $categoryId = $request->input('video_category_id');
        try {
            $this->videoService->updateVideo($video->id, $categoryId);

            return redirect()->route('videos.index')
                ->with('success', '編集を完了しました');
        } catch (Exception $e) {
            return redirect()->route('videos.index')
                ->with('error', '編集に失敗しました');
        }
    }

    public function delete(Request $request, Video $video)
    {
        try {
            $this->videoService->delete($video->id);

            return redirect()->route('videos.index')->with('success', '動画は正常に削除されました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('videos.index')->with('error', '動画は削除できません');
        }
    }

    public function bulkDelete(Request $request)
    {
        $videoIds = $request->input('checks', []);

        if (empty($videoIds)) {
            return redirect()->route('videos.index')->with('error', '削除対象の動画が選択されていません');
        }

        try {
            $result = $this->videoService->bulkDeleteVideos($videoIds);

            if ($result) {
                return redirect()->route('videos.index')->with('success', '選択した動画は正常に削除されました');
            }
            return redirect()->route('videos.index')->with('error', '選択した動画は削除できません');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('videos.index')->with('error', '選択した動画は削除できません');
        }
    }
}
