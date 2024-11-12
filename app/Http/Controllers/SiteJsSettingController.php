<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteJsSetting\StoreSiteJsSettingRequest;
use App\Http\Resources\SiteJsSetting\SiteJsSettingCollection;
use App\Services\SiteJsSettingService;

class SiteJsSettingController extends Controller
{
    private $siteJsSettingService;

    public function __construct(SiteJsSettingService $siteCssSettingService)
    {
        $this->siteJsSettingService = $siteCssSettingService;
    }

    public function index()
    {
        $items = $this->siteJsSettingService->getList();
        $lastItem = $this->siteJsSettingService->getLatest();

        return view('settings.site_js', [
            'items' => new SiteJsSettingCollection($items),
            'lastItem' => $lastItem,
        ]);
    }

    public function store(StoreSiteJsSettingRequest $request)
    {
        $dataCreate = array_merge($request->validated(), ['user_id' => auth()->id() ?: 1, 'site_id' => auth()->user()->site_id ?? 1]);
        $result = $this->siteJsSettingService->create($dataCreate);

        if ($result) {
            return redirect()->route('site_js_settings.index')->with('success', '編集が完了しました');
        }

        return redirect()->route('site_js_settings.index')->with('error', '編集に失敗しました');
    }
}
