<?php
namespace App\Http\Controllers;

use App\Services\PhoneCallService;
use Illuminate\Http\Request;

class ReportTelController extends Controller
{
    protected $phoneCallService;

    public function __construct(PhoneCallService $phoneCallAnalyticService)
    {
        $this->phoneCallService = $phoneCallAnalyticService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $period = $request->input('period', 'last_day');

        $events = $this->phoneCallService->getPhoneCallEvents(
            $period,
            $perPage,
            $page
        );

        return responseOkAPI([
            'tels' => $events
        ]);
    }
}
