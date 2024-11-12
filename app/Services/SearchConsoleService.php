<?php
namespace App\Services;

use App\Models\Site;
use Google\Client;
use Google\Service\SearchConsole;
use Google\Service\SearchConsole\SearchAnalyticsQueryRequest;
use Illuminate\Support\Facades\Auth;

class SearchConsoleService
{
    protected $client;
    protected $searchConsole;
    protected $site;

    public function __construct()
    {
        $site = Site::all()->first();
        $this->site = Auth::check() ? Auth::user()->site : $site;

        if (!$this->site) {
            throw new \Exception('No GA4 site found for current site ');
        }


        // Initialize Google Client
        $this->client = new Client();
        $this->client->setAuthConfig($this->site->getSearchConsoleConfigFullPath());
        $this->client->addScope('https://www.googleapis.com/auth/webmasters.readonly');

        $this->searchConsole = new SearchConsole($this->client);
    }

    public function getSearchKeywords($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            // Get date range
            $dateRange = $this->getDateRange($period);

            // Simple query first for testing
            $request = new SearchAnalyticsQueryRequest([
                'startDate' => $dateRange['start_date'],
                'endDate' => $dateRange['end_date'],
                'dimensions' => ['query'],
                'rowLimit' => 20
            ]);

            $response = $this->searchConsole->searchanalytics->query(
                config('services.google.search_console.site'),
                $request
            );

            $keywords = [];
            foreach ($response->getRows() as $row) {
                $keywords[] = [
                    $row->getKeys()[0],                    // keyword
                    (string)$row->getClicks(),            // clicks
                    (string)$row->getImpressions(),       // impressions
                    (string)round($row->getCtr() * 100, 2),  // CTR as percentage
                    (string)round($row->getPosition(), 1)    // average position
                ];
            }

            return [
                'rows' => $keywords
            ];

        } catch (\Exception $e) {
            \Log::error('Search Console Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'rows' => []
            ];
        }
    }

    public function getDateRange($period = 'last_month')
    {
        $endDate = date('Y-m-d');
        $startDate = match($period) {
            'last_day' => date('Y-m-d', strtotime('-1 day')),
            'last_week' => date('Y-m-d', strtotime('-7 days')),
            'last_month' => date('Y-m-d', strtotime('-30 days')),
            'last_3months' => date('Y-m-d', strtotime('-90 days')),
            'last_6months' => date('Y-m-d', strtotime('-180 days')),
            'last_year' => date('Y-m-d', strtotime('-365 days')),
            default => date('Y-m-d', strtotime('-30 days'))
        };

        return [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
    }

    protected function validateConfiguration()
    {
        if (empty($this->site->search_console_json_file) || !file_exists($this->site->getSearchConsoleConfigFullPath())) {
            throw new \Exception('Search console configuration file not found for this site');
        }
    }
}
