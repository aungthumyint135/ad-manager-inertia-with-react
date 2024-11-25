<?php

namespace App\Services\Admanager;

use Google\AdsApi\AdManager\v202411\Column;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\AdsApi\AdManager\v202411\Dimension;
use Google\AdsApi\AdManager\v202411\ReportJob;
use Google\AdsApi\AdManager\v202411\ReportQuery;
use Google\AdsApi\AdManager\v202411\ExportFormat;
use Google\AdsApi\AdManager\v202411\DateRangeType;
use Google\AdsApi\AdManager\v202411\ServiceFactory;
use Google\AdsApi\AdManager\AdManagerSessionBuilder;
use Google\AdsApi\AdManager\Util\v202411\ReportDownloader;
use Google\AdsApi\AdManager\Util\v202411\StatementBuilder;
use Google\AdsApi\AdManager\v202411\ReportQueryAdUnitView;

class AdmanagerService
{
    //setup credentials
    protected function getSession()
    {
        //change configuration according to the logged-in user(auth)
        $configFilePath = base_path('admanager-config/adsapi_php.ini');

        //2 options
        //1 - create agency_php.ini when agency is created
        //2 - store network_code agency record in table as new column

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($configFilePath)->build();

        // Construct an API session configured from an `adsapi_php.ini` file
        // and the OAuth2 credentials above.
        return (new AdManagerSessionBuilder())->fromFile($configFilePath)
            ->withOAuth2Credential($oAuth2Credential)
            ->build();
    }

     //reference code from  https://github.com/googleads/googleads-php-lib/blob/main/examples/AdManager/v202411/UserService/GetAllUsers.php
    public function getAllUsers()           // data of publishers, advisors those are belonged by agency
    {
        $session = $this->getSession();
        $serviceFactory = new ServiceFactory();

        $userService = $serviceFactory->createUserService($session);
        // Create a statement to select users.
        $pageSize = StatementBuilder::SUGGESTED_PAGE_LIMIT;
        $statementBuilder = (new StatementBuilder())->orderBy('id ASC')
            ->limit($pageSize);
        // Retrieve a small amount of users at a time, paging
        // through until all users have been retrieved.
        $totalResultSetSize = 0;
        $users = [];
        do {
            $page = $userService->getUsersByStatement(
                $statementBuilder->toStatement()
            );

            // Print out some information for each user.
            if ($page->getResults() !== null) {
                $totalResultSetSize = $page->getTotalResultSetSize();
                $i = $page->getStartIndex();
                foreach ($page->getResults() as $user) {
                    $users[] = [
                        'id' => $user->getId(),
                        'name' => $user->getName()
                    ];
                }
            }

            $statementBuilder->increaseOffsetBy($pageSize);
        } while ($statementBuilder->getOffset() < $totalResultSetSize);

        return $users;
    }

    //reference code from  https://github.com/googleads/googleads-php-lib/blob/main/examples/AdManager/v202411/SiteService/GetAllSites.php
    public function getAllSites()
    {
        $session = $this->getSession();
        $serviceFactory = new ServiceFactory();

        $siteService = $serviceFactory->createSiteService($session);

        // Create a statement to select sites.
        $pageSize = StatementBuilder::SUGGESTED_PAGE_LIMIT;
        $statementBuilder = (new StatementBuilder())->orderBy('id ASC')
            ->limit($pageSize);

        // Retrieve a small amount of sites at a time, paging
        // through until all sites have been retrieved.
        $totalResultSetSize = 0;
        $sites = [];
        do {
            $page = $siteService->getSitesByStatement(
                $statementBuilder->toStatement()
            );

            // Print out some information for each content.
            if ($page->getResults() !== null) {
                $totalResultSetSize = $page->getTotalResultSetSize();
                $i = $page->getStartIndex();
                foreach ($page->getResults() as $site) {
                    $sites[] = [
                        'id' => $site->getId(),
                        'url' => $site->getUrl(),
                    ];
                }
            }

            $statementBuilder->increaseOffsetBy($pageSize);
        } while ($statementBuilder->getOffset() < $totalResultSetSize);

        return $sites;
    }

    //reference code from https://github.com/googleads/googleads-php-lib/blob/main/examples/AdManager/v202411/ReportService/RunInventoryReport.php
    public function agencyReport()
    {
        $session = $this->getSession();
        $serviceFactory = new ServiceFactory();

        $reportService = $serviceFactory->createReportService($session);

        // Create report query.
        $reportQuery = new ReportQuery();
        $reportQuery->setDimensions(
            [
                // Dimension::SITE_NAME,
                // Dimension::AD_UNIT_ID,
                // Dimension::AD_UNIT_NAME,
                Dimension::LINE_ITEM_ID,
                // Dimension::LINE_ITEM_NAME,
                // Dimension::ADVERTISER_ID,
                // Dimension::ADVERTISER_NAME,
                // Dimension::ORDER_ID,
            ]
        );
        $reportQuery->setColumns(
            [
                // Column::AD_SERVER_IMPRESSIONS,
                // Column::AD_SERVER_CLICKS,
                // Column::AD_SERVER_CTR,
                // Column::AD_SERVER_CPM_AND_CPC_REVENUE,
                // Column::AD_SERVER_WITHOUT_CPD_AVERAGE_ECPM,

                //client want
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_IMPRESSIONS,
                // Column::AD_EXCHANGE_TOTAL_REQUEST_CTR,
                // Column::AD_EXCHANGE_TOTAL_REQUEST_ECPM,
                // Column::AD_EXCHANGE_LINE_ITEM_LEVEL_CLICKS,
                // Column::AD_EXCHANGE_LINE_ITEM_LEVEL_CTR,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_AVERAGE_ECPM,
                Column::AD_EXCHANGE_LINE_ITEM_LEVEL_REVENUE,


                // Column::TOTAL_LINE_ITEM_LEVEL_IMPRESSIONS,
                // Column::TOTAL_LINE_ITEM_LEVEL_CPM_AND_CPC_REVENUE,
                // Column::UNIQUE_REACH_IMPRESSIONS,
                // Column::AD_EXCHANGE_TOTAL_REQUESTS,
                // Column::DP_CLICKS,
                //Column::TOTAL_AD_REQUESTS,
            ]
        );

        // Set the ad unit view to hierarchical.
        $reportQuery->setAdUnitView(ReportQueryAdUnitView::HIERARCHICAL);
        // Set the start and end dates or choose a dynamic date range type.
        $reportQuery->setDateRangeType(DateRangeType::YESTERDAY);

        // Create report job and start it.
        $reportJob = new ReportJob();
        $reportJob->setReportQuery($reportQuery);
        $reportJob = $reportService->runReportJob($reportJob);

        // Create report downloader to poll report's status and download when
        // ready.
        $reportDownloader = new ReportDownloader(
            $reportService,
            $reportJob->getId()
        );
        if ($reportDownloader->waitForReportToFinish()) {
            $reportFilePath = tempnam(sys_get_temp_dir(), 'report') . '%s.csv.gz';
            $reportDownloader->downloadReport('CSV_DUMP', $reportFilePath);

            // Decompress and read the CSV content
            $csvContent = decompressGzFile($reportFilePath);

            // Ensure the CSV content is properly encoded in UTF-8
            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'UTF-8');

            // Parse the CSV_DUMP content into an array format
            $reportData = parseCsvToArray($csvContent);

            return $reportData;
        } else {
            return response()->json(['error' => 'Failed to download report.'], 500);
        }
    }


    public function publisherReport()
    {
        $session = $this->getSession();
        $serviceFactory = new ServiceFactory();

        $reportService = $serviceFactory->createReportService($session);

        // Create report query.
        $reportQuery = new ReportQuery();
        $reportQuery->setDimensions(
            [
                Dimension::SITE_NAME,
                Dimension::AD_UNIT_ID,
                Dimension::AD_UNIT_NAME,
            ]
        );
        $reportQuery->setColumns(
            [
                Column::AD_SERVER_IMPRESSIONS,
                Column::AD_SERVER_CLICKS,
                Column::AD_SERVER_CTR,
                Column::AD_SERVER_CPM_AND_CPC_REVENUE,
                Column::AD_SERVER_WITHOUT_CPD_AVERAGE_ECPM,
            ]
        );

        // Set the ad unit view to hierarchical.
        $reportQuery->setAdUnitView(ReportQueryAdUnitView::HIERARCHICAL);
        // Set the start and end dates or choose a dynamic date range type.
        $reportQuery->setDateRangeType(DateRangeType::YESTERDAY);

        // Create report job and start it.
        $reportJob = new ReportJob();
        $reportJob->setReportQuery($reportQuery);
        $reportJob = $reportService->runReportJob($reportJob);

        // Create report downloader to poll report's status and download when
        // ready.
        $reportDownloader = new ReportDownloader(
            $reportService,
            $reportJob->getId()
        );
        if ($reportDownloader->waitForReportToFinish()) {
            $reportFilePath = tempnam(sys_get_temp_dir(), 'report') . '%s.csv.gz';
            $reportDownloader->downloadReport('CSV_DUMP', $reportFilePath);

            // Decompress and read the CSV content
            $csvContent = decompressGzFile($reportFilePath);

            // Ensure the CSV content is properly encoded in UTF-8
            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'UTF-8');

            // Parse the CSV_DUMP content into an array format
            $reportData = parseCsvToArray($csvContent);

            return $reportData;
        } else {
            return response()->json(['error' => 'Failed to download report.'], 500);
        }
    }

    public function advertiserReport()
    {
        $session = $this->getSession();
        $serviceFactory = new ServiceFactory();

        $reportService = $serviceFactory->createReportService($session);

        // Create report query.
        $reportQuery = new ReportQuery();
        $reportQuery->setDimensions(
            [
                Dimension::SITE_NAME,
                Dimension::AD_UNIT_ID,
                Dimension::AD_UNIT_NAME,
                Dimension::LINE_ITEM_ID,
                Dimension::LINE_ITEM_NAME,
                Dimension::ORDER_ID,
                Dimension::ORDER_NAME, //campaign
            ]
        );
        $reportQuery->setColumns(
            [
                Column::AD_SERVER_IMPRESSIONS,
                Column::AD_SERVER_CLICKS,
                Column::AD_SERVER_CTR,
                Column::AD_SERVER_CPM_AND_CPC_REVENUE,
                Column::AD_SERVER_WITHOUT_CPD_AVERAGE_ECPM,
            ]
        );

        // Set the ad unit view to hierarchical.
        $reportQuery->setAdUnitView(ReportQueryAdUnitView::HIERARCHICAL);
        // Set the start and end dates or choose a dynamic date range type.
        $reportQuery->setDateRangeType(DateRangeType::YESTERDAY);

        // Create report job and start it.
        $reportJob = new ReportJob();
        $reportJob->setReportQuery($reportQuery);
        $reportJob = $reportService->runReportJob($reportJob);

        // Create report downloader to poll report's status and download when
        // ready.
        $reportDownloader = new ReportDownloader(
            $reportService,
            $reportJob->getId()
        );
        if ($reportDownloader->waitForReportToFinish()) {
            $reportFilePath = tempnam(sys_get_temp_dir(), 'report') . '%s.csv.gz';
            $reportDownloader->downloadReport('CSV_DUMP', $reportFilePath);

            // Decompress and read the CSV content
            $csvContent = decompressGzFile($reportFilePath);

            // Ensure the CSV content is properly encoded in UTF-8
            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'UTF-8');

            // Parse the CSV_DUMP content into an array format
            $reportData = parseCsvToArray($csvContent);

            return $reportData;
        } else {
            return response()->json(['error' => 'Failed to download report.'], 500);
        }
    }
}
