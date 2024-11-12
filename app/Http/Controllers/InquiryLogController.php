<?php

namespace App\Http\Controllers;

use App\Models\InquiryLog;
use App\Services\InquiryLogService;
use Illuminate\Http\Request;
use App\Traits\CsvTrait;
use Log;
use Response;

class InquiryLogController extends Controller
{
    use CsvTrait;

    public const PER_PAGE_OPTIONS = [
        ['count' => '10', 'label' => '10件表示'],
        ['count' => '20', 'label' => '20件表示'],
        ['count' => '50', 'label' => '50件表示'],
        ['count' => '100', 'label' => '100件表示'],
        ['count' => '200', 'label' => '200件表示'],
    ];

    protected $ilService;

    public function __construct(InquiryLogService $ilService)
    {
        $this->ilService = $ilService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $inquiryFormId)
    {

        $messages = [
            'received_at_from' => '期間(from)の指定が正しくありません',
            'received_at_to' => '期間(to)の指定が正しくありません',
        ];

        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'received_at_from' => ['date_format:Y-m-d'],
            'received_at_to' => ['date_format:Y-m-d'],
        ], $messages);

        $validated['inquiry_form_id'] = $inquiryFormId;

        $items = $this->ilService->list($validated);
        $columns = ['received_at' => '受信日時', 'ip_address' => 'IPアドレス'];
        $perPageOptions = self::PER_PAGE_OPTIONS;
        $listActions = ['detail', 'selectable'];

        return view('inquiry_log.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'listActions',
            'inquiryFormId',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(InquiryLog $inquiryLog)
    {
        return view('inquiry_log.show', compact(
            'inquiryLog',
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InquiryLog $inquiryLog)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->ilService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'お問い合わせ内容を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'お問い合わせ内容を一括削除できませんでした');
            }
        }
    }   //

    public function downloadCSV(Request $request, $enc)
    {
        $model = $this->ilService->list($request, false);
        $fileName = date('YmdHis') . '.csv';

        $callback = function () use ($model, $enc) {
            $header = ['受信日時', '本文', 'ユーザーエージェント', 'IPアドレス'];
            $this->exportToCsv($model, $header, $enc);
        };

        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ]);
    }
}
