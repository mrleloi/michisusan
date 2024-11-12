<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteCssSetting\StoreSiteCssSettingRequest;
use App\Http\Resources\SiteCssSetting\SiteCssSettingCollection;
use App\Services\SiteCssSettingService;

class SiteCssSettingController extends Controller
{
    private $siteCssSettingService;

    public function __construct(SiteCssSettingService $siteCssSettingService)
    {
        $this->siteCssSettingService = $siteCssSettingService;
    }

    public function index()
    {
        $items = $this->siteCssSettingService->getList();
        $lastItem = $this->siteCssSettingService->getLatest();

        return view('settings.site_css', [
            'items' => new SiteCssSettingCollection($items),
            'lastItem' => $lastItem,
        ]);
    }

    public function store(StoreSiteCssSettingRequest $request)
    {
        $dataCreate = array_merge($request->validated(), ['user_id' => auth()->id() ?: 1, 'site_id' => auth()->user()->site_id ?? 1]);
        $result = $this->siteCssSettingService->create($dataCreate);

        if ($result) {
            return redirect()->route('site_css_settings.index')->with('success', '編集が完了しました');
        }

        return redirect()->route('site_css_settings.index')->with('error', '編集に失敗しました');
    }
}
