<?php
namespace App\Services;

use App\Models\ChangeLog;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ChangeLogService
{
    public function getChangeLogsSummary($period = 'last_month', $filters = [])
    {
        $query = ChangeLog::query()
            ->when(isset($filters['site_id']), function($q) use ($filters) {
                $q->where('site_id', $filters['site_id']);
            })
            ->when(isset($filters['table_name']), function($q) use ($filters) {
                $q->where('table_name', $filters['table_name']);
            })
            ->whereIn('status', [ChangeLog::STATUS_CREATED, ChangeLog::STATUS_UPDATED]);

        // Add date range
        $endDate = now();
        $startDate = match($period) {
            'last_day' => $endDate->copy()->subDay(),
            'last_week' => $endDate->copy()->subWeek(),
            'last_month' => $endDate->copy()->subMonth(),
            'last_3months' => $endDate->copy()->subMonths(3),
            'last_6months' => $endDate->copy()->subMonths(6),
            'last_year' => $endDate->copy()->subYear(),
            default => $endDate->copy()->subMonth()
        };

        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Group logs by date
        $logs = $query->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($log) {
                return $log->created_at->format('Y-m-d');
            })
            ->map(function($dayLogs) {
                // Maximum 4 logs per day to display on the dashboard
                return $dayLogs->take(4)->map(function($log) {
                    return [
                        'id' => $log->id,
                        'site_id' => $log->site_id,
                        'user_id' => $log->user_id,
                        'table_name' => $log->table_name,
                        'record_id' => $log->record_id,
                        'page_title' => $log->page_title,
                        'status' => $log->status_text,
                        'created' => $log->created_at->format('Y-m-d\TH:i:sP'),
                        'updated_at' => $log->updated_at->format('Y/m/d H:i:s'),
                        'diff_time' => $this->getDiffTime($log->updated_at),
                        'user_name' => $log->user_name,
                        'path' => $this->generatePath($log)
                    ];
                });
            })
            ->flatten(1); // Flatten grouped results

        return $logs;
    }

    public function index($period = 'last_month', $filters = [])
    {
        return ChangeLog::query()
            ->when(isset($filters['site_id']), function($q) use ($filters) {
                $q->where('site_id', $filters['site_id']);
            })
            ->when(isset($filters['table_name']), function($q) use ($filters) {
                $q->where('table_name', $filters['table_name']);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($log) {
                return [
                    'id' => $log->id,
                    'site_id' => $log->site_id,
                    'user_id' => $log->user_id,
                    'table_name' => $log->table_name,
                    'record_id' => $log->record_id,
                    'page_title' => $log->page_title,
                    'status' => $log->status_text,
                    'created' => $log->created_at->format('Y-m-d\TH:i:sP'),
                    'updated_at' => $log->updated_at->format('Y/m/d H:i:s'),
                    'diff_time' => $this->getDiffTime($log->updated_at),
                    'user_name' => $log->user_name,
                    'path' => $this->generatePath($log)
                ];
            });
    }

    public function paginateLogs($logs, $page = 1, $perPage = 10)
    {
        $items = $logs->forPage($page, $perPage);

        return new LengthAwarePaginator(
            $items,
            $logs->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );
    }

    protected function generatePath($log)
    {
        // Generate path based on table_name, status, and record_id
        $basePath = '/admin/';

        $path = match($log->table_name) {
            'pages' => 'pages',
            'news_articles' => 'news_articles',
            'blog_posts' => 'blog_posts',
            default => strtolower(str_replace(' ', '_', $log->table_name))
        };

        if ($log->status === ChangeLog::STATUS_CREATED) {
            return $basePath . $path . '/' . $log->record_id . '/edit';
        } else if ($log->status === ChangeLog::STATUS_UPDATED) {
            return $basePath . $path . '/' . $log->record_id . '/edit';
        }

        return $basePath . $path;
    }

    private function getDiffTime($datetime)
    {
        $now = Carbon::now();
        $diffTime = $datetime->diffInDays($now, false);

        if ($diffTime > 0) {
            return (int) $diffTime . "日前";
        } else {
            $diffHours = $datetime->diffInHours($now, false);
            return (int) $diffHours . "時間前";
        }
    }
}
