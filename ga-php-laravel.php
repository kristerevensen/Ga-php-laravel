use Google_Client;
use Google_Service_AnalyticsReporting;

$client = new Google_Client();
$client->setAuthConfig('/path/to/client_secret.json');
$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
$analytics = new Google_Service_AnalyticsReporting($client);

// Set the Google Analytics view ID for the report
$viewId = 'YOUR_VIEW_ID';

// Create the DateRange object.
$dateRange = new Google_Service_AnalyticsReporting_DateRange();
$dateRange->setStartDate('2022-01-01');
$dateRange->setEndDate('2022-01-31');

// Create the Metrics object.
$sessions = new Google_Service_AnalyticsReporting_Metric();
$sessions->setExpression('ga:sessions');
$pageviews = new Google_Service_AnalyticsReporting_Metric();
$pageviews->setExpression('ga:pageviews');

// Create the Dimensions object.
$defaultChannelGrouping = new Google_Service_AnalyticsReporting_Dimension();
$defaultChannelGrouping->setName('ga:channelGrouping');

// Create the ReportRequest object.
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId($viewId);
$request->setDateRanges($dateRange);
$request->setMetrics([$sessions, $pageviews]);
$request->setDimensions([$defaultChannelGrouping]);

// Call the Reports API.
$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests([$request]);
$response = $analytics->reports->batchGet($body);

// Loop through the report data and save to database
foreach ($response->getReports()[0]->getData()->getRows() as $row) {
    $channelGrouping = $row->getDimensions()[0];
    $sessions = $row->getMetrics()[0]->getValues()[0];
    $pageviews = $row->getMetrics()[0]->getValues()[1];

    // Save to MySQL database
    DB::table('analytics_data')->insert([
        'channel_grouping' => $channelGrouping,
        'sessions' => $sessions,
        'pageviews' => $pageviews,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
