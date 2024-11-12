<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeforeAfterSettingRequest;
use App\Http\Requests\UpdateBeforeAfterSettingRequest;
use App\Models\BeforeAfterSetting;
use App\Services\BeforeAfterSettingService;
use Illuminate\Http\Request;
use Auth;

class BeforeAfterSettingController extends Controller
{
    protected $basService;

    public function __construct(BeforeAfterSettingService $basService)
    {
        $this->basService = $basService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $beforeAfterSetting = BeforeAfterSetting::query()->where('site_id', Auth::user()->site_id)->first();
        if ($beforeAfterSetting) {
            return redirect(route('before_after_setting.edit', ['before_after_setting' => $beforeAfterSetting]));
        } else {
            return redirect(route('before_after_setting.create'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $naviMenuTypes = $this->basService->getNaviMenuTypes();
        $footerTypes = $this->basService->getFooterTypes();
        $listlDesignTypes = $this->basService->getListDesignTypes();
        $numberOfItemsTypes = $this->basService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->basService->getCategoryNaviTypes();
        $articleOrderTypes = $this->basService->getArticleOrderTypes();
        $subnavigationTypes = $this->basService->getSubnavigationTypes();
        $positionTypes = $this->basService->getPositionTypes();
        $visibleOptions = $this->basService->getVisibleOptions();

        return view('embed_parts.before_after_setting.create', compact(
            'naviMenuTypes',
            'footerTypes',
            'listlDesignTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            //'beforeAfterSetting',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeforeAfterSettingRequest $request)
    {
        //
        $beforeAfterSetting = $this->basService->store($request->all());
        if ($beforeAfterSetting->update($request->all())) {
            return redirect(route('before_after_setting.edit', ['before_after_setting' => $beforeAfterSetting]))->with('success', 'ギャラリー設定をを更新しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ギャラリー設定を更新できませんでした');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BeforeAfterSetting $beforeAfterSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeforeAfterSetting $beforeAfterSetting)
    {
        /*
        $beforeAfterSetting = BeforeAfterSetting::find($id);
        if( !$beforeAfterSetting ) {
            return redirect(route('before_after_setting.create'));
        }
        */

        //
        $naviMenuTypes = $this->basService->getNaviMenuTypes();
        $footerTypes = $this->basService->getFooterTypes();
        $listlDesignTypes = $this->basService->getListDesignTypes();
        $numberOfItemsTypes = $this->basService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->basService->getCategoryNaviTypes();
        $articleOrderTypes = $this->basService->getArticleOrderTypes();
        $subnavigationTypes = $this->basService->getSubnavigationTypes();
        $positionTypes = $this->basService->getPositionTypes();
        $visibleOptions = $this->basService->getVisibleOptions();

        return view('embed_parts.before_after_setting.edit', compact(
            'naviMenuTypes',
            'footerTypes',
            'listlDesignTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            'beforeAfterSetting',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeforeAfterSettingRequest $request, BeforeAfterSetting $beforeAfterSetting)
    {
        //
        //\Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //\Log::debug('beforeAfterSetting validated',[$validated]);

        if (isset($validated['header_image_id_delete']) && $validated['header_image_id_delete'] == 1) {
            $request['header_image_id'] = null;
        }

        //Log::debug('beforeAfterSetting request',[$request->all(),$beforeAfterSetting]);
        if ($beforeAfterSetting->updateOrCreate(['id' => $beforeAfterSetting->id], $request->all())) {
            //$this->basService->syncBeforeAfterSettingImages($beforeAfterSetting, $request->input("gii", []));
            return redirect(route('before_after_setting.edit', ['before_after_setting' => $beforeAfterSetting]))->with('success', 'ビフォーアフター設定を変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'ビフォーアフター設定を変更できませんでした');
        }
    }
}
