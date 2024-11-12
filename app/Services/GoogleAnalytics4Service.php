<?php

namespace App\Services;

use App\Models\Site;
use Carbon\Carbon;
use Google\Analytics\Data\V1alpha\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\DateRange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DateTime;
use DateInterval;
use DatePeriod;

class GoogleAnalytics4Service
{
    protected $propertyId;
    protected $client;
    protected $site;
    protected $phoneCallService;

    public function __construct(PhoneCallService $phoneCallService)
    {
        $site = Site::all()->first();
        $this->site = Auth::check() ? Auth::user()->site : $site;
        $this->phoneCallService = $phoneCallService;

        if (!$this->site) {
            throw new \Exception('No GA4 site found for current site ');
        }

        $this->propertyId = $this->site->ga4_property_id;

        if (!Storage::exists($this->site->getGa4ConfigPath())) {
            throw new \Exception('GA4 configuration file not found for current site');
        }

        $this->client = new BetaAnalyticsDataClient([
            'credentials' => $this->site->getGa4ConfigFullPath()
        ]);
    }

    protected function validateConfiguration()
    {
        if (empty($this->propertyId)) {
            throw new \Exception('GA4 property ID not configured for this site');
        }

        if (empty($this->site->ga4_json_file) || !file_exists($this->site->getGa4ConfigFullPath())) {
            throw new \Exception('GA4 configuration file not found for this site');
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

        return new DateRange([
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function getBasicMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            // Get basic metrics
            $metricsResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'totalUsers']),
                    new Metric(['name' => 'sessions'])
                ]
            ]);

            // Get conversion events
            $conversionResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'eventCount'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'eventName'])
                ]
            ]);

            // Process basic metrics
            $pageViews = 0;
            $uniqueUsers = 0;
            $sessions = 0;

            if ($metricsResponse->getRows()->count() > 0) {
                $metrics = $metricsResponse->getRows()[0]->getMetricValues();
                $pageViews = (int)$metrics[0]->getValue();
                $uniqueUsers = (int)$metrics[1]->getValue();
                $sessions = (int)$metrics[2]->getValue();
            }

            // Process conversions
            $webCv = 0;

            foreach ($conversionResponse->getRows() as $row) {
                $eventName = strtolower($row->getDimensionValues()[0]->getValue());
                $count = (int)$row->getMetricValues()[0]->getValue();

                /*if ($eventName === 'phone_call') {
                    $telCv += $count;
                } else*/
                if ($eventName === 'form_submit') {
                    $webCv += $count;
                }
            }

            // Get phone calls from service
            $phoneCallMetrics = $this->phoneCallService->getBasicMetrics($period);
            $telCv = $phoneCallMetrics['phone_calls'];

            // Calculate CVR
            $totalConversions = $telCv + $webCv;
            $cvr = $sessions > 0 ? round(($totalConversions / $sessions) * 100, 2) : 0;

            // Format response
            $response = [
                'rows' => [
                    [
                        (string)$pageViews,      // PageViews
                        (string)$uniqueUsers,    // UniqueUsers
                        (string)$sessions,       // Sessions
                        (string)$cvr,            // CVR (percentage)
                        (string)$telCv,          // TEL CV
                        (string)$webCv           // WEB CV
                    ]
                ]
            ];

            return $response;

        } catch (\Exception $e) {
            \Log::error('GA4 Basic Metrics Error: ' . $e->getMessage());
            return [
                'rows' => [
                    ["0", "0", "0", "0", "0", "0"] // Default values when error
                ]
            ];
        }
    }

    public function getConversionMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $dateRange = $this->getDateRange($period);
            $startDate = new \DateTime($dateRange->getStartDate());
            $endDate = new \DateTime($dateRange->getEndDate());

            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$dateRange],
                'metrics' => [
                    new Metric(['name' => 'eventCount'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'date']),
                    new Dimension(['name' => 'eventName']),
                ],
            ]);

            // Initialize result array with all dates
            $result = [];
            $interval = new DateInterval('P1D');
            $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            foreach ($dateRange as $date) {
                $dateKey = $date->format('Ymd');
                $result[$dateKey] = [
                    'tel' => 0,
                    'form' => 0,
                    'total' => 0
                ];
            }

            // Get and process phone call data from service
            $phoneCallData = $this->phoneCallService->getConversionMetrics($period);
            foreach ($phoneCallData as $date => $data) {
                if (isset($result[$date])) {
                    $result[$date]['tel'] = $data['tel'];
                    $result[$date]['total'] = $data['tel']; // Reset total as we'll add form submissions later
                }
            }

            // Process form submission data from GA4
            foreach ($response->getRows() as $row) {
                $date = $row->getDimensionValues()[0]->getValue();
                $eventName = strtolower($row->getDimensionValues()[1]->getValue());
                $count = (int)$row->getMetricValues()[0]->getValue();

                if (isset($result[$date]) && $eventName === 'form_submit') {
                    $result[$date]['form'] = $count;
                    $result[$date]['total'] += $count; // Add form submissions to total
                }
            }

            ksort($result);
            return $result;

        } catch (\Exception $e) {
            \Log::error('GA4 Event API Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

    public function getCVRMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            // Get GA4 DateRange object
            $dateRange = $this->getDateRange($period);

            // Query GA4 metrics
            $metricsResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$dateRange],
                'dimensions' => [
                    new Dimension(['name' => 'date'])
                ],
                'metrics' => [
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'totalUsers'])
                ]
            ]);

            // Get form submissions
            $formResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$dateRange],
                'dimensions' => [
                    new Dimension(['name' => 'date']),
                    new Dimension(['name' => 'eventName'])
                ],
                'metrics' => [
                    new Metric(['name' => 'eventCount'])
                ]
            ]);

            // Initialize result array
            $result = [];
            $startDate = new \DateTime($dateRange->getStartDate());
            $endDate = new \DateTime($dateRange->getEndDate());
            $interval = new \DateInterval('P1D');
            $datePeriod = new \DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            foreach ($datePeriod as $date) {
                $dateKey = $date->format('Ymd');
                $result[$dateKey] = [
                    $dateKey,
                    "0",  // conversions
                    "0",  // sessions
                    "0",  // pageviews
                    "0"   // users
                ];
            }

            // Get phone call data
            $phoneCallData = $this->phoneCallService->getConversionMetrics($period);

            // Process all conversions
            $conversions = [];

            // Add phone call conversions
            foreach ($phoneCallData as $date => $data) {
                $conversions[$date] = $data['tel'];
            }

            // Add form submissions
            foreach ($formResponse->getRows() as $row) {
                $date = $row->getDimensionValues()[0]->getValue();
                $eventName = strtolower($row->getDimensionValues()[1]->getValue());

                if ($eventName === 'form_submit') {
                    if (!isset($conversions[$date])) {
                        $conversions[$date] = 0;
                    }
                    $conversions[$date] += (int)$row->getMetricValues()[0]->getValue();
                }
            }

            // Fill in metrics data
            foreach ($metricsResponse->getRows() as $row) {
                $date = $row->getDimensionValues()[0]->getValue();
                $metrics = $row->getMetricValues();

                $result[$date] = [
                    $date,
                    (string)($conversions[$date] ?? 0),     // Total conversions (phone + form)
                    (string)$metrics[0]->getValue() ?? '',        // sessions
                    (string)$metrics[1]->getValue() ?? '',        // pageviews
                    (string)$metrics[2]->getValue() ?? ''         // users
                ];
            }

            // Sort by date and convert to numeric array
            ksort($result);
            $rows = array_values($result);

            return [
                'rows' => $rows
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 CVR Metrics Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return [
                'rows' => []
            ];
        }
    }

    public function getTrafficSourceMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'sessions'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'sessionSource'])
                ]
            ]);

            $paths = [];
            $totalSessions = 0;
            $accountedSessions = 0;

            foreach ($response->getRows() as $row) {
                $source = strtolower($row->getDimensionValues()[0]->getValue());
                $sessions = (int)$row->getMetricValues()[0]->getValue();
                $totalSessions += $sessions;

                $sourceName = match($source) {
                    'organic' => 'Organic Search',
                    '(direct)' => 'Direct',
                    'referral' => 'Referral',
                    'organic_social', 'social' => 'Organic Social',
                    'paid_search' => 'Paid Search',
                    'paid_social' => 'Paid Social',
                    'email' => 'Email',
                    'affiliates' => 'Affiliates',
                    'display' => 'Display',
                    'video' => 'Organic Video',
                    'paid_video' => 'Paid Video',
                    'audio' => 'Audio',
                    'sms' => 'SMS',
                    'push' => 'Push Notification',
                    'unknown' => 'Unassigned',
                    default => null
                };

                if ($sourceName !== null) {
                    // Aggregate sessions by mapped source name
                    $found = false;
                    foreach ($paths as &$path) {
                        if ($path[0] === $sourceName) {
                            $path[1] = (string)((int)$path[1] + $sessions);
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $paths[] = [$sourceName, (string)$sessions];
                    }
                    $accountedSessions += $sessions;
                }
            }

            // Add Other category for unmatched sessions
            $otherSessions = $totalSessions - $accountedSessions;
            if ($otherSessions > 0) {
                $paths[] = ['Other', (string)$otherSessions];
            }

            // Sort by sessions (DESC)
            usort($paths, function($a, $b) {
                return (int)$b[1] - (int)$a[1];
            });

            return [
                'rows' => $paths
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 Traffic Source API Error: ' . $e->getMessage());
            return [
                'rows' => []
            ];
        }
    }

    public function getDeviceMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'sessions'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'deviceCategory'])
                ]
            ]);

            $devices = [];
            foreach ($response->getRows() as $row) {
                $device = $row->getDimensionValues()[0]->getValue();
                $sessions = $row->getMetricValues()[0]->getValue();

                // Normalize device names to match expected format
                $deviceName = strtolower($device); // GA4 trả về 'DESKTOP', 'MOBILE', 'TABLET'
                $devices[] = [$deviceName, (string)$sessions];
            }

            // Sort by sessions (DESC)
            usort($devices, function($a, $b) {
                return (int)$b[1] - (int)$a[1];
            });

            return [
                'rows' => $devices
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 Device Metrics Error: ' . $e->getMessage());
            return [
                'rows' => []
            ];
        }
    }
    public function getBrowserMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'sessions'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'browser'])
                ]
            ]);

            $browsers = [];
            $totalSessions = 0;
            $accountedSessions = 0;

            // First pass: collect total sessions
            foreach ($response->getRows() as $row) {
                $browser = $row->getDimensionValues()[0]->getValue();
                $sessions = (int)$row->getMetricValues()[0]->getValue();
                $totalSessions += $sessions;

                // Map browser names
                $browserName = match($browser) {
                    // Chromium-based browsers
                    'Chrome' => 'Chrome',
                    'Chrome Mobile' => 'Chrome',
                    'Chrome Mobile iOS' => 'Chrome',
                    'Chrome Mobile WebView' => 'Chrome',
                    'Chrome Headless' => 'Chrome',
                    'Chromium' => 'Chrome',

                    // Safari variants
                    'Safari' => 'Safari',
                    'Mobile Safari' => 'Safari',
                    'Safari (in-app)' => 'Safari (in-app)',
                    'WebKit' => 'Safari',
                    'Safari iPad' => 'Safari',
                    'Safari iPhone' => 'Safari',

                    // Microsoft browsers
                    'Edge' => 'Edge',
                    'Microsoft Edge' => 'Edge',
                    'Edge Mobile' => 'Edge',
                    'Internet Explorer' => 'Internet Explorer',
                    'IE Mobile' => 'Internet Explorer',

                    // Mozilla
                    'Firefox' => 'Firefox',
                    'Firefox Mobile' => 'Firefox',
                    'Firefox iOS' => 'Firefox',
                    'Mozilla' => 'Firefox',

                    // Mobile-specific browsers
                    'Samsung Browser' => 'Samsung Internet',
                    'Samsung Internet' => 'Samsung Internet',
                    'Android Browser' => 'Android Browser',
                    'Android Webview' => 'Android Webview',
                    'MIUI Browser' => 'MIUI Browser',
                    'UC Browser' => 'UC Browser',
                    'Opera Mini' => 'Opera Mini',

                    // Other major browsers
                    'Opera' => 'Opera',
                    'Opera Mobile' => 'Opera',
                    'Opera Touch' => 'Opera',
                    'Brave' => 'Brave',
                    'Vivaldi' => 'Vivaldi',
                    'Yandex Browser' => 'Yandex',

                    // Specialized browsers
                    'Amazon Silk' => 'Amazon Silk',
                    'DuckDuckGo' => 'DuckDuckGo',
                    'Huawei Browser' => 'Huawei Browser',
                    'QQ Browser' => 'QQ Browser',
                    'Sogou Explorer' => 'Sogou',
                    'WeChat' => 'WeChat',

                    // Default cases
                    null => 'Other',
                    default => null
                };

                if ($browserName !== null) {
                    $browsers[] = [$browserName, (string)$sessions];
                    $accountedSessions += $sessions;
                }
            }

            // Calculate Other
            $otherSessions = $totalSessions - $accountedSessions;
            if ($otherSessions > 0) {
                $browsers[] = ['Other', (string)$otherSessions];
            }

            // Sort by sessions (DESC)
            usort($browsers, function($a, $b) {
                return (int)$b[1] - (int)$a[1]; // Sort DESC
            });

            return [
                'browser' => [
                    'rows' => $browsers
                ]
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 Browser Metrics Error: ' . $e->getMessage());
            return [
                'browser' => [
                    'rows' => []
                ]
            ];
        }
    }

    public function getRegionMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'sessions'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'region'])
                ]
            ]);

            $domestics = [];
            foreach ($response->getRows() as $row) {
                $region = $row->getDimensionValues()[0]->getValue() ?? '(not set)';
                $sessions = $row->getMetricValues()[0]->getValue();

                $domestics[] = [$region, (string)$sessions];
            }

            // Sort by sessions (ASC)
            usort($domestics, function($a, $b) {
                return (int)$a[1] - (int)$b[1];
            });

            return [
                'rows' => $domestics
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 Region Metrics Error: ' . $e->getMessage());
            return [
                'rows' => []
            ];
        }
    }

    public function getCityMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$this->getDateRange($period)],
                'metrics' => [
                    new Metric(['name' => 'sessions'])
                ],
                'dimensions' => [
                    new Dimension(['name' => 'city'])
                ]
            ]);

            $citys = [];
            foreach ($response->getRows() as $row) {
                $city = $row->getDimensionValues()[0]->getValue() ?? '(not set)';
                $sessions = $row->getMetricValues()[0]->getValue();

                $citys[] = [$city, (string)$sessions];
            }

            // Sort by sessions (ASC)
            usort($citys, function($a, $b) {
                return (int)$a[1] - (int)$b[1];
            });

            return [
                'rows' => $citys
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 City Metrics Error: ' . $e->getMessage());
            return [
                'rows' => []
            ];
        }
    }

    public function getBounceMetrics($period = 'last_month')
    {
        $this->validateConfiguration();

        try {
            $weekRange = $this->getDateRange('last_week');
            $monthRange = $this->getDateRange('last_month');

            // Weekly data
            $weekResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$weekRange],
                'metrics' => [
                    new Metric(['name' => 'sessions']),        // Total sessions
                    new Metric(['name' => 'bounceRate']),      // Bounce rate
                    new Metric(['name' => 'newUsers']),        // New users
                    new Metric(['name' => 'totalUsers'])       // Total users
                ]
            ]);

            // Monthly data
            $monthResponse = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [$monthRange],
                'metrics' => [
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'bounceRate']),
                    new Metric(['name' => 'newUsers']),
                    new Metric(['name' => 'totalUsers'])
                ]
            ]);

            // Process weekly data
            $weekMetrics = [0, 0, 0, 0];
            if ($weekResponse->getRows()->count() > 0) {
                $metrics = $weekResponse->getRows()[0]->getMetricValues();
                $weekSessions = (int)$metrics[0]->getValue();
                $weekBounceRate = round($metrics[1]->getValue(), 2);
                $weekBounces = (int)($weekSessions * $weekBounceRate / 100); // Calculate bounces from rate
                $weekNewUsers = (int)$metrics[2]->getValue();
                $weekReturningUsers = (int)$metrics[3]->getValue() - (int)$metrics[2]->getValue();
            }

            // Process monthly data
            $monthMetrics = [0, 0, 0, 0];
            if ($monthResponse->getRows()->count() > 0) {
                $metrics = $monthResponse->getRows()[0]->getMetricValues();
                $monthSessions = (int)$metrics[0]->getValue();
                $monthBounceRate = round($metrics[1]->getValue(), 2);
                $monthBounces = (int)($monthSessions * $monthBounceRate / 100); // Calculate bounces from rate
                $monthNewUsers = (int)$metrics[2]->getValue();
                $monthReturningUsers = (int)$metrics[3]->getValue() - (int)$metrics[2]->getValue();
            }

            return [
                'rows' => [
                    [
                        (string)$weekBounces,           // Weekly bounces
                        (string)$monthBounces,          // Monthly bounces
                        (string)$weekBounceRate,        // Weekly bounce rate
                        (string)$monthBounceRate,       // Monthly bounce rate
                        (string)$weekNewUsers,          // Weekly new users
                        (string)$monthNewUsers,         // Monthly new users
                        (string)$weekReturningUsers,    // Weekly repeat users
                        (string)$monthReturningUsers    // Monthly repeat users
                    ]
                ]
            ];

        } catch (\Exception $e) {
            \Log::error('GA4 Bounce Metrics Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'rows' => [
                    ["0", "0", "0", "0", "0", "0", "0", "0"]
                ]
            ];
        }
    }
}
