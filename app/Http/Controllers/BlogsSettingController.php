<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogsSettings\UpdateBlogsSettingRequest;
use App\Http\Resources\BlogsSettings\BlogsSettingUpdateResource;
use App\Models\Site;
use App\Services\BlogsSettingService;
use App\Services\BlogsSubnavigationService;
use Illuminate\Support\Facades\Auth;

class BlogsSettingController extends Controller
{
    protected $blogsSettingService;
    protected $blogsSubnavigationService;

    public function __construct(
        BlogsSettingService $blogsSettingService,
        BlogsSubnavigationService $blogsSubnavigationService,
    ) {
        $this->blogsSettingService = $blogsSettingService;
        $this->blogsSubnavigationService = $blogsSubnavigationService;
    }

    public function edit()
    {
        $siteId = Auth::check() ? Auth::user()->site_id : 1; // Temporary fake site_id
        $blogsSetting = $this->blogsSettingService->getSettingOrFake($siteId);
        $designs = $this->blogsSettingService->getAllDesigns();
        $subnavigations = $this->blogsSubnavigationService->getAllSubNavigations();

        return view('blogs_posts.setting', [
            'path' => route('blogs_settings.update'),
            'blogsSetting' => new BlogsSettingUpdateResource($blogsSetting),
            'designs' => $designs,
            'subnavigations' => $subnavigations,
        ]);
    }

    public function update(UpdateBlogsSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['site_id'] = Auth::check() ? Auth::user()->site_id : Site::all()->first()->id;

            $result = $this->blogsSettingService->updateSetting($validatedData);

            if ($result) {
                return redirect()->route('blogs_settings.edit')->with('success', '新着情報が正常に更新されました。');
            }
            return redirect()->route('blogs_settings.edit')->with('error', '新着情報の更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の更新中にエラーが発生しました。');
        }
    }
}
