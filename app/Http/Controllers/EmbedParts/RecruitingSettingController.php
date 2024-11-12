<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecruitingSettingRequest;
use App\Http\Requests\UpdateRecruitingSettingRequest;
use App\Models\RecruitingSetting;
use App\Services\RecruitingSettingService;
use Illuminate\Http\Request;
use Auth;

class RecruitingSettingController extends Controller
{
    protected $rsService;

    public function __construct(RecruitingSettingService $rsService)
    {
        $this->rsService = $rsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $recruitingSetting = RecruitingSetting::first();
        if ($recruitingSetting) {
            return redirect(route('recruiting_setting.edit', ['recruiting_setting' => $recruitingSetting]));
        } else {
            return redirect(route('recruiting_setting.create'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $naviMenuTypes = $this->rsService->getNaviMenuTypes();
        $commonFooterTypes = $this->rsService->getCommonFooterTypes();
        $designTypes = $this->rsService->getDesignTypes();
        $showDetailPageTypes = $this->rsService->getShowDetailPageTypes();
        $numberOfItemsTypes = $this->rsService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->rsService->getCategoryNaviTypes();
        $articleOrderTypes = $this->rsService->getArticleOrderTypes();
        $subnavigationTypes = $this->rsService->getSubnavigationTypes();
        $positionTypes = $this->rsService->getPositionTypes();
        $visibleOptions = $this->rsService->getVisibleOptions();

        return view('embed_parts.recruiting_setting.create', compact(
            'naviMenuTypes',
            'commonFooterTypes',
            'designTypes',
            'showDetailPageTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            //'recruitingSetting',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecruitingSettingRequest $request)
    {
        //
        $recruitingSetting = $this->rsService->store($request->validated());
        if ($recruitingSetting) {
            return redirect(route('recruiting_setting.edit', ['recruiting_setting' => $recruitingSetting]))->with('success', '求人情報設定をを更新しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報設定を更新できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitingSetting $recruitingSetting)
    {
        $naviMenuTypes = $this->rsService->getNaviMenuTypes();
        $commonFooterTypes = $this->rsService->getCommonFooterTypes();
        $designTypes = $this->rsService->getDesignTypes();
        $showDetailPageTypes = $this->rsService->getShowDetailPageTypes();
        $numberOfItemsTypes = $this->rsService->getNumberOfItemsTypes();
        $categoryNaviTypes = $this->rsService->getCategoryNaviTypes();
        $articleOrderTypes = $this->rsService->getArticleOrderTypes();
        $subnavigationTypes = $this->rsService->getSubnavigationTypes();
        $positionTypes = $this->rsService->getPositionTypes();
        $visibleOptions = $this->rsService->getVisibleOptions();

        return view('embed_parts.recruiting_setting.edit', compact(
            'naviMenuTypes',
            'commonFooterTypes',
            'designTypes',
            'showDetailPageTypes',
            'numberOfItemsTypes',
            'categoryNaviTypes',
            'articleOrderTypes',
            'subnavigationTypes',
            'positionTypes',
            'visibleOptions',
            'recruitingSetting',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecruitingSettingRequest $request, RecruitingSetting $recruitingSetting)
    {
        //
        //\Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //\Log::debug('recruitingSetting validated',[$validated]);

        if (isset($validated['header_image_id_delete']) && $validated['header_image_id_delete'] == 1) {
            $request['header_image_id'] = null;
        }

        //Log::debug('recruitingSetting request',[$request->all(),$recruitingSetting]);
        if ($recruitingSetting->updateOrCreate(['id' => $recruitingSetting->id], $request->all())) {
            //$this->rsService->syncRecruitingSettingImages($recruitingSetting, $request->input("gii", []));
            return redirect(route('recruiting_setting.edit', ['recruiting_setting' => $recruitingSetting]))->with('success', '求人情報設定を変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報設定を変更できませんでした');
        }
    }
}
