<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGallerySettingRequest;
use App\Http\Requests\UpdateGallerySettingRequest;
use App\Models\GallerySetting;
use App\Services\GallerySettingService;
use Illuminate\Http\Request;
use Auth;
use Exception;

class GallerySettingController extends Controller
{
    protected $gsService;

    public function __construct(GallerySettingService $gsService)
    {
        $this->gsService = $gsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gallerySetting = GallerySetting::query()->where('site_id', Auth::user()->site_id)->first();
        if ($gallerySetting) {
            return redirect(route('gallery_setting.edit', ['gallery_setting' => $gallerySetting]));
        } else {
            return redirect(route('gallery_setting.create'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $naviMenuTypes = $this->gsService->getNaviMenuTypes();
        $footerTypes = $this->gsService->getFooterTypes();
        $listlDesignTypes = $this->gsService->getListDesignTypes();
        $detailDesignTypes = $this->gsService->getDetailDesignTypes();
        $showDetailPageTypes = $this->gsService->getShowDetailPageTypes();
        $numberOfItemsTypes = $this->gsService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->gsService->getCategoryNaviTypes();
        $articleOrderTypes = $this->gsService->getArticleOrderTypes();
        $subnavigationTypes = $this->gsService->getSubnavigationTypes();
        $positionTypes = $this->gsService->getPositionTypes();
        $visibleOptions = $this->gsService->getVisibleOptions();

        return view('embed_parts.gallery_setting.create', compact(
            'naviMenuTypes',
            'footerTypes',
            'listlDesignTypes',
            'detailDesignTypes',
            'showDetailPageTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            //'gallerySetting',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGallerySettingRequest $request)
    {
        //
        $gallerySetting = $this->gsService->store($request->all());
        if ($gallerySetting) {
            return redirect(route('gallery_setting.edit', ['gallery_setting' => $gallerySetting]))->with('success', 'ギャラリー設定をを更新しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリー設定を更新できませんでした');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GallerySetting $gallerySetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GallerySetting $gallerySetting)
    {
        /*
        $gallerySetting = GallerySetting::find($id);
        if( !$gallerySetting ) {
            return redirect(route('gallery_setting.create'));
        }
        */

        //
        $naviMenuTypes = $this->gsService->getNaviMenuTypes();
        $footerTypes = $this->gsService->getFooterTypes();
        $listlDesignTypes = $this->gsService->getListDesignTypes();
        $detailDesignTypes = $this->gsService->getDetailDesignTypes();
        $showDetailPageTypes = $this->gsService->getShowDetailPageTypes();
        $numberOfItemsTypes = $this->gsService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->gsService->getCategoryNaviTypes();
        $articleOrderTypes = $this->gsService->getArticleOrderTypes();
        $subnavigationTypes = $this->gsService->getSubnavigationTypes();
        $positionTypes = $this->gsService->getPositionTypes();
        $visibleOptions = $this->gsService->getVisibleOptions();

        return view('embed_parts.gallery_setting.edit', compact(
            'naviMenuTypes',
            'footerTypes',
            'listlDesignTypes',
            'detailDesignTypes',
            'showDetailPageTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            'gallerySetting',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGallerySettingRequest $request, GallerySetting $gallerySetting)
    {
        //
        //\Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //\Log::debug('gallerySetting validated',[$validated]);

        if (isset($validated['header_image_id_delete']) && $validated['header_image_id_delete'] == 1) {
            $request['header_image_id'] = null;
        }

        //Log::debug('gallerySetting request',[$request->all(),$gallerySetting]);
        try {
            if ($gallerySetting->updateOrCreate(['id' => $gallerySetting->id], $request->all())) {
                //$this->gsService->syncGallerySettingImages($gallerySetting, $request->input("gii", []));
                return redirect(route('gallery_setting.edit', ['gallery_setting' => $gallerySetting]))->with('success', 'ギャラリー設定を変更しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'ギャラリー設定を変更できませんでした');
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'ギャラリー設定を変更できませんでした');
        }
    }
}
