<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChangeLogService;
use App\Services\EmbedPartsService;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    protected $changeLogService;

    public function __construct(ChangeLogService $changeLogService)
    {
        $this->changeLogService = $changeLogService;
    }

    public function index(Request $request)
    {
        $period = $request->input('period', 'last_month');
        $filters = [
            'site_id' => $request->input('site_id') ?: 1,
            'table_name' => $request->input('table_name'),
            'status' => $request->input('status'),
        ];

        $logs = $this->changeLogService->index($period, $filters);
        $pagination = $this->changeLogService->paginateLogs(
            $logs,
            $request->input('page', 1),
            $request->input('per_page', 10)
        );

        if ($request->method() === 'POST') {
            $logs = $this->changeLogService->getChangeLogsSummary($period, $filters);
            $pagination = $this->changeLogService->paginateLogs(
                $logs,
                $request->input('page', 1),
                $request->input('per_page', 10)
            );

            return responseOkAPI([
                'change_logs' => $pagination->items(),
            ]);
        }

        return view('change_logs.index', [
            'items' => $pagination,
            'perPageOptions' => EmbedPartsService::PER_PAGE_OPTIONS,
        ]);
    }
}
