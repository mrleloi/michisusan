<?php
namespace App\Services;

use App\Models\PhoneCallLog;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhoneCallService
{
    protected $site_id;

    public function __construct()
    {
        $site = Site::all()->first();
        $this->site_id = Auth::check() ? Auth::user()->site_id : $site->id;

        if (!$this->site_id) {
            throw new \Exception('No site found');
        }
    }

    protected function validateConfiguration()
    {
        if (!$this->site_id) {
            throw new \Exception('Site configuration not found');
        }
    }

    public function getPhoneCallEvents($period = 'last_month', $limit = 10, $page = 1)
    {
        $this->validateConfiguration();

        try {
            $dateRange = $this->getDateRange($period);

            $query = PhoneCallLog::where('site_id', $this->site_id)
                ->whereBetween('created_at', [
                    $dateRange['start_date'],
                    $dateRange['end_date']
                ]);

            $total = $query->count();

            $items = $query->orderBy('created_at', 'desc')
                ->skip(($page - 1) * $limit)
                ->take($limit)
                ->get()
                ->map(function ($call) {
                    return [
                        'page_url' => $call->page_location,
                        'page_title' => $call->page_title,
                        'page_path' => $call->page_path,
                        'phone_number' => $call->phone_number,
                        'button_position' => $call->button_position,
                        'user_agent' => $call->user_agent,
                        'ip_address' => $call->access_ip,
                        'date_time' => $call->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return [
                'items' => $items,
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'last_page' => ceil($total / $limit)
            ];

        } catch (\Exception $e) {
            \Log::error('Phone Call Events Error: ' . $e->getMessage());
            return [
                'items' => [],
                'total' => 0,
                'per_page' => $limit,
                'current_page' => 1,
                'last_page' => 1
            ];
        }
    }

    public function getDateRange($period = 'last_month')
    {
        $endDate = Carbon::now();
        $startDate = match($period) {
            'last_day' => Carbon::now()->subDay(),
            'last_week' => Carbon::now()->subDays(7),
            'last_month' => Carbon::now()->subDays(30),
            'last_3months' => Carbon::now()->subDays(90),
            'last_6months' => Carbon::now()->subDays(180),
            'last_year' => Carbon::now()->subDays(365),
            default => Carbon::now()->subDays(30)
        };

        return [
            'start_date' => $startDate->startOfDay(),
            'end_date' => $endDate->endOfDay()
        ];
    }

    public function getBasicMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $dateRange = $this->getDateRange($period);

            $phoneCallCount = PhoneCallLog::where('site_id', $this->site_id)
                ->whereBetween('created_at', [
                    $dateRange['start_date'],
                    $dateRange['end_date']
                ])
                ->count();

            return [
                'phone_calls' => $phoneCallCount,
                'date_range' => $dateRange
            ];

        } catch (\Exception $e) {
            \Log::error('Phone Call Basic Metrics Error: ' . $e->getMessage());
            return [
                'phone_calls' => 0,
                'date_range' => $dateRange ?? null
            ];
        }
    }

    public function getConversionMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            // Get date range based on period
            $endDate = Carbon::now();
            $startDate = match($period) {
                'last_day' => Carbon::now()->subDay(),
                'last_week' => Carbon::now()->subDays(7),
                'last_month' => Carbon::now()->subDays(30),
                'last_3months' => Carbon::now()->subDays(90),
                'last_6months' => Carbon::now()->subDays(180),
                'last_year' => Carbon::now()->subDays(365),
                default => Carbon::now()->subDays(30)
            };

            // Get daily counts
            $dailyCounts = PhoneCallLog::where('site_id', $this->site_id)
                ->whereBetween('created_at', [
                    $startDate->startOfDay(),
                    $endDate->endOfDay()
                ])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->get()
                ->pluck('count', 'date')
                ->toArray();

            // Initialize result array with all dates
            $result = [];
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $dateKey = $currentDate->format('Ymd');
                $dateStr = $currentDate->format('Y-m-d');

                $result[$dateKey] = [
                    'tel' => $dailyCounts[$dateStr] ?? 0,
                    'form' => 0,
                    'total' => $dailyCounts[$dateStr] ?? 0
                ];

                $currentDate->addDay();
            }

            ksort($result);
            return $result;

        } catch (\Exception $e) {
            \Log::error('Phone Call Conversion Metrics Error: ' . $e->getMessage());
            return $this->getEmptyConversionResult($startDate, $endDate);
        }
    }

    private function getEmptyConversionResult($startDate, $endDate)
    {
        $result = [];
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Ymd');
            $result[$dateKey] = [
                'tel' => 0,
                'form' => 0,
                'total' => 0
            ];
            $currentDate->addDay();
        }

        return $result;
    }

    public function create(array $data): PhoneCallLog
    {
        return PhoneCallLog::create($data);
    }

    public function getPhoneCallMetrics(string $period = 'last_month', int $limit = 10, int $page = 1)
    {
        $query = PhoneCallLog::query();

        // Add date range filter
        $endDate = Carbon::now();
        $startDate = match($period) {
            'last_day' => Carbon::now()->subDay(),
            'last_week' => Carbon::now()->subDays(7),
            'last_month' => Carbon::now()->subDays(30),
            'last_3months' => Carbon::now()->subDays(90),
            'last_6months' => Carbon::now()->subDays(180),
            'last_year' => Carbon::now()->subDays(365),
            default => Carbon::now()->subDays(30)
        };

        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Get total count
        $total = $query->count();

        // Get paginated results
        $items = $query->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get()
            ->map(function ($call) {
                return [
                    'date' => $call->created_at->format('Y-m-d\TH:i:sP'),
                    'page_url' => $call->page_location,
                    'phone_number' => $call->phone_number,
                    'button_position' => $call->button_position,
                    'user_agent' => $call->user_agent,
                    'ip_address' => $call->access_ip,
                ];
            });

        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $limit,
            'current_page' => $page,
            'last_page' => ceil($total / $limit)
        ];
    }
}
