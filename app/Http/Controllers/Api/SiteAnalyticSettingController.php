<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Services\ChangeLogService;
use App\Services\GoogleAnalytics4Service;
use App\Services\SearchConsoleService;
use Illuminate\Http\Request;

class SiteAnalyticSettingController extends Controller
{
    protected $googleAnalyticsService;
    protected $searchConsoleService;

    public function __construct(
        GoogleAnalytics4Service $googleAnalyticsService,
        SearchConsoleService $searchConsoleService,
        ChangeLogService $changeLogService,
    ){
        $site = Site::all()->first();
        if (!$site) {
            throw new \Exception('Site ID is required');
        }

        $this->googleAnalyticsService = $googleAnalyticsService;
        $this->searchConsoleService = $searchConsoleService;
        $this->changeLogService = $changeLogService;
    }

    public function getReportData(Request $request)
    {
        $request->validate([
            'mode' => 'required|string',
        ]);

        try {
            $mode = $request->input('mode');
            $period = $this->getPeriodFromMode($mode);

            switch (true) {
                case str_contains($request->mode, 'basic'):
                    return responseOkAPI([
                        'basic_metrics' => $this->googleAnalyticsService->getBasicMetrics($period)
                    ]);

                case str_contains($request->mode, 'cvr_graph'):
                    return responseOkAPI([
                        'change_log' => $this->changeLogService->getChangeLogsSummary($period),
                        'cvr' => $this->googleAnalyticsService->getCVRMetrics($period)
                    ]);

                case str_contains($request->mode, 'path_graph'):
                    return responseOkAPI([
                        'paths' => $this->googleAnalyticsService->getTrafficSourceMetrics($period)
                    ]);

                case str_contains($request->mode, 'device_graph'):
                    return responseOkAPI([
                        'devices' => $this->googleAnalyticsService->getDeviceMetrics($period)
                    ]);

                case str_contains($request->mode, 'browser_graph'):
                    return responseOkAPI([
                        'browser' => $this->googleAnalyticsService->getBrowserMetrics($period)
                    ]);

                case str_contains($request->mode, 'domestic_graph'):
                    return responseOkAPI([
                        'domestics' => $this->googleAnalyticsService->getRegionMetrics($period)
                    ]);

                case str_contains($request->mode, 'city_graph'):
                    return responseOkAPI([
                        'citys' => $this->googleAnalyticsService->getCityMetrics($period)
                    ]);

                case str_contains($mode, 'bounces'):
                    return responseOkAPI([
                        'bounces' => $this->googleAnalyticsService->getBounceMetrics()
                    ]);

                default:
                    return responseOkAPI([
                        'error' => 'Invalid mode specified'
                    ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        }
    }

    public function getConversionData(Request $request)
    {
        try {
            $mode = $request->input('mode');
            $period = $this->getPeriodFromMode($mode);

            return responseOkAPI([
                'conversion_data' => $this->googleAnalyticsService->getConversionMetrics($period),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        }
    }

    public function getSearchConsoleData(Request $request)
    {
        try {
            $mode = $request->input('mode');
            $period = $this->getPeriodFromMode($mode);

            return responseOkAPI([
                'keywords' => $this->searchConsoleService->getSearchKeywords($period),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        }
    }

    private function getPeriodFromMode($mode)
    {
        if (str_contains($mode, 'oneDay')) {
            return 'last_day';
        } elseif (str_contains($mode, 'oneWeek')) {
            return 'last_week';
        } elseif (str_contains($mode, 'oneMonth')) {
            return 'last_month';
        } elseif (str_contains($mode, 'threeMonths')) {
            return 'last_3months';
        } elseif (str_contains($mode, 'sixMonths')) {
            return 'last_6months';
        } elseif (str_contains($mode, 'oneYear')) {
            return 'last_year';
        }
        return 'last_month';
    }
}
