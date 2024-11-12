<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsArticles\UpdateNewsArticleRequest;
use App\Http\Requests\NewsSettings\UpdateNewsSettingRequest;
use App\Http\Resources\NewsArticles\NewsArticleUpdateResource;
use App\Http\Resources\NewsSettings\NewsSettingUpdateResource;
use App\Models\NewsArticle;
use App\Services\NewsSettingService;
use App\Services\NewsSubnavigationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsSettingController extends Controller
{
    protected $newsSettingService;
    protected $newsSubnavigationService;

    public function __construct(
        NewsSettingService $newsSettingService,
        NewsSubnavigationService $newsSubnavigationService,
    ) {
        $this->newsSettingService = $newsSettingService;
        $this->newsSubnavigationService = $newsSubnavigationService;
    }

    public function edit()
    {
        $siteId = Auth::check() ? Auth::user()->site_id : 1; // Temporary fake site_id
        $newsSetting = $this->newsSettingService->getSettingOrFake($siteId);
        $designs = $this->newsSettingService->getAllDesigns();
        $subnavigations = $this->newsSubnavigationService->getAllSubNavigations();

        return view('news_articles.setting', [
            'path' => route('news_settings.update'),
            'newsSetting' => new NewsSettingUpdateResource($newsSetting),
            'designs' => $designs,
            'subnavigations' => $subnavigations,
        ]);
    }

    public function update(UpdateNewsSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if (!Auth::check()) { // Temporary fake site_id
                $validatedData['site_id'] = 1;
            } else {
                $validatedData['site_id'] = Auth::user()->site_id;
            }

            $result = $this->newsSettingService->updateSetting($validatedData);

            if ($result) {
                return redirect()->route('news_settings.edit')->with('success', '新着情報が正常に更新されました。');
            }
            return redirect()->route('news_settings.edit')->with('error', '新着情報の更新中にエラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', '新着情報の更新中にエラーが発生しました。');
        }
    }
}
