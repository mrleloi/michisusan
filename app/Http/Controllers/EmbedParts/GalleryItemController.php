<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryItemRequest;
use App\Http\Requests\UpdateGalleryItemRequest;
use App\Models\GalleryItem;
use App\Services\EmbedPartsService;
use App\Services\GalleryItemService;
use Illuminate\Http\Request;
use Log;

class GalleryItemController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryItemService $galleryService)
    {
        $this->galleryService = $galleryService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
            'category_id' => ['integer'],
            'visible' => ['integer'],
            'keyword' => [],
        ]);

        $items = $this->galleryService->list($validated);
        $columns = ['visible:visible' => '表示', 'title' => 'ギャラリー名', 'gallery_category.name' => 'カテゴリ名', 'image.filename:image' => '画像'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $categoryOptions = $this->galleryService->getCategoryOfCurrentSite(true);
        $visibleOptions = array_merge([['key' => '', 'label' => '表示・非表示']], EmbedPartsService::VISIBLE_OPTIONS);

        return view('embed_parts.gallery_item.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'categoryOptions',
            'visibleOptions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $galleryCategories = $this->galleryService->getCategoryOfCurrentSite();
        $buttonShowTypes = $this->galleryService->getButtonShowTypes();
        $buttonLinkTypes = $this->galleryService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->galleryService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $galleryItemImages = array_fill(0, 5, []);

        return view('embed_parts.gallery_item.create', compact(
            'galleryCategories',
            'buttonShowTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            //'galleryItem',
            'galleryItemImages',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryItemRequest $request)
    {
        //
        $galleryItem = $this->galleryService->store($request->all());
        if ($galleryItem) {
            return redirect(route('gallery_item.edit', ['gallery_item' => $galleryItem]))->with('success', 'ギャラリーをを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーを追加できませんでした');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryItem $galleryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryItem $galleryItem)
    {
        //
        $galleryCategories = $this->galleryService->getCategoryOfCurrentSite();
        $buttonShowTypes = $this->galleryService->getButtonShowTypes();
        $buttonLinkTypes = $this->galleryService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->galleryService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $galleryItemImages = $galleryItem->galleryItemImages()->orderBy("sort_order")->get();
        if (count($galleryItemImages) < 5) {
            $galleryItemImages = $galleryItemImages->concat(array_fill(0, 5 - count($galleryItemImages), []));
        }

        return view('embed_parts.gallery_item.edit', compact(
            'galleryCategories',
            'buttonShowTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            'galleryItem',
            'galleryItemImages',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryItemRequest $request, GalleryItem $galleryItem)
    {
        //
        //\Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //\Log::debug('galleryItem validated',[$validated]);

        if (isset($validated['image_id_delete']) && $validated['image_id_delete'] == 1) {
            $request['image_id'] = null;
        }

        //Log::debug('galleryItem request',[$request->all(),$galleryItem]);
        if ($galleryItem->update($request->all())) {
            $this->galleryService->syncGalleryItemImages($galleryItem, $request->input("rows", []));
            return redirect(route('gallery_item.edit', ['gallery_item' => $galleryItem]))->with('success', 'ギャラリーを変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryItem $galleryItem)
    {
        if ($galleryItem->delete()) {
            return redirect()->back()->withInput()->with('success', 'ギャラリーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリーを削除できませんでした');
        }
    }

    public function copy(GalleryItem $galleryItem)
    {
        $galleryCategories = $this->galleryService->getCategoryOfCurrentSite();
        $buttonShowTypes = $this->galleryService->getButtonShowTypes();
        $buttonLinkTypes = $this->galleryService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->galleryService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $galleryItemImages = array_fill(0, 5, []);
        $galleryItem = $galleryItem->replicate();

        return view('embed_parts.gallery_item.create', compact(
            'galleryCategories',
            'buttonShowTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            'galleryItem',
            'galleryItemImages',
        ));

    }


    public function registCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['max:250'],
        ]);

        return response()->json($this->galleryService->registerCategory($validated));
    }

}
