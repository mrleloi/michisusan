<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteSettings\UpdateAnalyticSettingRequest;
use App\Http\Requests\SiteSettings\UpdateAdvancedSettingRequest;
use App\Http\Requests\SiteSettings\UpdateEmbeddedScriptSettingRequest;
use App\Http\Requests\SiteSettings\UpdateSitemapSettingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Models\Site;
use App\Services\SiteSettingService;
use App\Http\Requests\SiteSettings\UpdateGeneralSettingRequest;
use App\Http\Requests\SiteSettings\UpdateInitialSettingRequest;
use App\Http\Requests\SiteSettings\UpdateAppearanceSettingRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected $service;

    public function __construct(
        SiteSettingService $service,
    ) {
        $this->service = $service;
    }

    public function general(Request $request)
    {
        $site = Site::all()->first();
        $seoTitleSeparators = $this->service->getSeoTitleSeparators();
        $wwwPatterns = $this->service->getWWWPatterns();
        $cookiePolicies = $this->service->getCookiePolicies();
        return view(
            'settings.general', [
            'site' => $site,
            'seoTitleSeparators' => $seoTitleSeparators,
            'wwwPatterns' => $wwwPatterns,
            'cookiePolicies' => $cookiePolicies,
            ]
        );
    }

    public function updateGeneral(UpdateGeneralSettingRequest $request)
    {
        $validatedData = $request->validated();
        $files = [];
        foreach (['favicon_image', 'apple_touch_icon_image'] as $key) {
            $file = $request->file($key);
            if ($file && $file->isValid()) {
                $files[$key] = $request->file($key);
            }
        }
        $site = Site::all()->first();
        $result = $this->service->updateGeneral($site, $validatedData, $files);
        if ($result) {
            return redirect()->route('setting.general')->with('success', '正常に保存しました。');
        }
        return back()->withInput()->with('error', 'エラーが発生しました。');
    }

    public function initial(Request $request)
    {
        $site = Site::all()->first();
        $industryOptions = $this->service->getIndustryOptions();
        return view(
            'settings.initial', [
            'site' => $site,
            'industryOptions' => $industryOptions,
            ]
        );
    }

    public function updateInitial(UpdateInitialSettingRequest $request)
    {
        $validatedData = $request->validated();
        $site = Site::all()->first();
        $result = $this->service->updateInitial($site, $validatedData);
        if ($result) {
            return redirect()->route('setting.initial')->with('success', '正常に保存しました。');
        }
        return back()->withInput()->with('error', 'エラーが発生しました。');
    }

    public function appearance(Request $request)
    {
        $site = Site::all()->first();
        $industryOptions = $this->service->getIndustryOptions();
        return view(
            'settings.appearance', [
            'site' => $site,
            'service' => $this->service,
            ]
        );
    }

    public function updateAppearance(UpdateAppearanceSettingRequest $request)
    {
        $validatedData = $request->validated();
        $site = Site::all()->first();
        $result = $this->service->updateAppearance($site, $validatedData);
        if ($result) {
            return redirect()->route('setting.appearance')->with('success', '正常に保存しました。');
        }
        return back()->withInput()->with('error', 'エラーが発生しました。');
    }

    public function embeddedScript(Request $request)
    {
        $site = Site::all()->first();
        return view(
            'settings.embedded_script', [
                'site' => $site,
            ]
        );
    }

    public function updateEmbeddedScript(UpdateEmbeddedScriptSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $site = Site::all()->first();
            $result = $this->service->updateEmbeddedScript($site, $validatedData);
            if ($result) {
                return redirect()->route('settings.embedded_script.edit')->with('success', '正常に保存しました。');
            }
            return back()->withInput()->with('error', 'エラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'エラーが発生しました。');
        }
    }

    public function sitemap(Request $request)
    {
        $site = Site::all()->first();
        return view(
            'settings.site_map', [
                'site' => $site,
            ]
        );
    }

    public function updateSitemap(UpdateSitemapSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $site = Site::all()->first();
            $result = $this->service->updateSitemap($site, $validatedData);
            if ($result) {
                return redirect()->route('settings.sitemap.edit')->with('success', '正常に保存しました。');
            }
            return back()->withInput()->with('error', 'エラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'エラーが発生しました。');
        }
    }

    public function analytic(Request $request)
    {
        $site = Auth::check() ? Site::query()->find(Auth::user()->site_id) : Site::all()->first();
        return view(
            'settings.analytic', [
                'site' => $site,
            ]
        );
    }

    public function updateAnalytic(UpdateAnalyticSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $site = Auth::check() ? Site::query()->find(Auth::user()->site_id) : Site::all()->first();

            if ($request->hasFile('ga4_json_file')) {
                $file = $request->file('ga4_json_file');

                // Get the relative storage path
                $relativePath = $site->getGa4ConfigPath();

                // Ensure directory exists
                Storage::makeDirectory(dirname($relativePath));

                // Store new file
                Storage::putFileAs(
                    dirname($relativePath),
                    $file,
                    basename($relativePath)
                );

                // Save the relative path to database
                $validatedData['ga4_json_file'] = $relativePath;
            }

            if ($request->hasFile('search_console_json_file')) {
                $file = $request->file('search_console_json_file');

                // Get the relative storage path
                $relativePath = $site->getSearchConsoleConfigPath();

                // Ensure directory exists
                Storage::makeDirectory(dirname($relativePath));

                // Store new file
                Storage::putFileAs(
                    dirname($relativePath),
                    $file,
                    basename($relativePath)
                );

                // Save the relative path to database
                $validatedData['search_console_json_file'] = $relativePath;
            }

            $result = $this->service->updateAnalytic($site, $validatedData);
            if ($result) {
                return redirect()->route('site_analytic_settings.index')->with('success', '正常に保存しました。');
            }
            return back()->withInput()->with('error', 'エラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'エラーが発生しました。');
        }
    }

    public function advanced(Request $request)
    {
        $site = Site::all()->first();
        return view(
            'settings.advanced', [
                'site' => $site,
            ]
        );
    }

    public function updateAdvanced(UpdateAdvancedSettingRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $site = Site::all()->first();
            $result = $this->service->updateAdvanced($site, $validatedData);
            if ($result) {
                return redirect()->route('settings.advanced.edit')->with('success', '正常に保存しました。');
            }
            return back()->withInput()->with('error', 'エラーが発生しました。');
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput()->with('error', 'エラーが発生しました。');
        }
    }
}
