<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteSnsSeting\UpdateSiteSnsSettingRequest;
use App\Http\Resources\SiteSnsSetting\SiteSnsSettingResource;
use App\Services\SiteSnsSettingService;
use Exception;

class SiteSnsSettingController extends Controller
{
    private $siteSnsSettingService;

    public function __construct(SiteSnsSettingService $siteSnsSettingService)
    {
        $this->siteSnsSettingService = $siteSnsSettingService;
    }

    public function index()
    {
        $snsSetting = $this->siteSnsSettingService->findBySiteId(auth()->user()->site_id ?: 1);

        return view('settings.site_sns', [
            'item' => new SiteSnsSettingResource($snsSetting),
        ]);
    }

    public function update(UpdateSiteSnsSettingRequest $request)
    {
        try {
            $this->siteSnsSettingService->updateOrCreate(auth()->user()->site_id ?: 1, $request->validated());
            $this->siteSnsSettingService->deleteImages(
                $request->only(['other1_image_delete', 'other2_image_delete', 'other3_image_delete'])
            );

            return redirect()->route('site_sns_settings.index')->with('success', '編集が完了しました');
        } catch (Exception $e) {
            return back()->withInput()->with('error', '編集に失敗しました');
        }
    }
}
