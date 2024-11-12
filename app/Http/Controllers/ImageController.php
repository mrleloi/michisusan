<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageFileListRequest;
use App\Http\Requests\Images\StoreImageRequest;
use App\Models\ImageFile;
use App\Services\ImageFileService;
use Exception;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $ifService;

    public function __construct(ImageFileService $ifService)
    {
        $this->ifService = $ifService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'image_file_category_id' => ['nullable', 'integer'],
        ]);

        $categoryId = $validated['image_file_category_id'] ?? null;

        $categoryList = $this->ifService->getCategories();

        $selectAllCategory = [
            'id' => null,
            'name' => 'カテゴリー 一覧'
        ];
        $categoryList->prepend((object) $selectAllCategory);

        $items = $this->ifService->list($validated);

        return view('images.index', compact('items', 'categoryList', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryList = $this->ifService->getCategories();
        $qualityOptions = ImageFileService::QUALITY_OPTIONS;

        return view('images.create', compact(
            'categoryList','qualityOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $files = $request->file('file');
        $categoryId = $request->input('image_file_category_id');
        $quality = $request->input('quality');
        try {
            $result = $this->ifService->upload($files, $categoryId, $quality);

            if ($result) {
                return redirect()->route('images.index')->with('success', '追加を完了しました');
            }
        } catch (Exception $e) {
            return redirect()->route('images.create')
                ->with('error', 'アップロードできませんでした');
        }
    }

    public function edit($imageId)
    {
        $image = $this->ifService->get($imageId);
        $categoryList = $this->ifService->getCategories();
        $qualityOptions = ImageFileService::QUALITY_OPTIONS;
        $path = route('images.update', ['image' => $imageId]);

        return view('images.edit', compact(
            'image','categoryList','qualityOptions','path'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $imageId)
    {
        $request->validate([
            'image_file_category_id' => 'exists:image_file_categories,id',
        ]);

        $categoryId = $request->input('image_file_category_id');
        try {
            $this->ifService->updateImage($imageId, $categoryId);

            return redirect()->route('images.index')
                ->with('success', '編集を完了しました');
        } catch (Exception $e) {
            return redirect()->route('images.index')
                ->with('error', '編集に失敗しました');
        }
    }

    public function delete(Request $request, ImageFile $image)
    {
        try {
            $this->ifService->delete($image->id);

            return redirect()->route('images.index')->with('success', '写真は正常に削除されました');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('images.index')->with('error', '写真は削除できません');
        }
    }

    public function bulkDelete(Request $request)
    {
        $imageIds = $request->input('checks', []);

        if (empty($imageIds)) {
            return redirect()->route('images.index')->with('error', '削除する写真が選択されていません');
        }

        try {
            $result = $this->ifService->bulkDeleteImages($imageIds);

            if ($result) {
                return redirect()->route('images.index')->with('success', '選択した写真は正常に削除されました');
            }
            return redirect()->route('images.index')->with('error', '選択した写真は削除できません');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('images.index')->with('error', '選択した写真は削除できません');
        }
    }
}
