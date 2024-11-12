<?php

namespace App\Http\Controllers;

use App\Http\Requests\SitePaymentSetting\UpdateSitePaymentSettingRequest;
use App\Http\Resources\SitePaymentSetting\SitePaymentSettingResource;
use App\Services\SitePaymentSettingService;
use Illuminate\Support\Facades\Log;
use Exception;

class SitePaymentSettingController extends Controller
{
    private $sitePaymentService;

    public function __construct(SitePaymentSettingService $sitePaymentService)
    {
        $this->sitePaymentService = $sitePaymentService;
    }

    public function index()
    {
        $item = $this->sitePaymentService->findBySiteId(auth()->user()->site_id);

        return view('settings.site_payment', [
            'item' => new SitePaymentSettingResource($item)
        ]);
    }

    public function update(UpdateSitePaymentSettingRequest $request)
    {
        try {
            $this->sitePaymentService->createOrUpdate(auth()->user()->site_id, $request->validated());

            return redirect()->route('site_payment_settings.index')->with('success', '編集が完了しました');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('site_payment_settings.index')->with('error', '編集に失敗しました');
        }
    }
}
