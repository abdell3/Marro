<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface
{
    public function createReport(array $data);
    public function updateReportStatus($reportId, $status, $handlerId);
    public function getPendingReports();
    public function getUserReports($userId);
    public function getReportById($reportId);
    public function getReportsByReportable($reportableType, $reportableId);
}
