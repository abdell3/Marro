<?php

namespace App\Services;

use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\ReportRepository;

class ReportService
{
    /**
     * Create a new class instance.
     */


    protected $reportRepo;


    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }


    public function createReport(array $data)
    {
        return $this->reportRepo->createReport($data);
    }

    public function handleReport($reportId, $status, $handlerId)
    {
        $report = $this->reportRepo->updateReportStatus($reportId, $status, $handlerId);

        if($status === "approved")
        {
            $report->reportable->delete();
        }

        return $report;
    } 


    public function getPendingReport()
    {
        return $this->reportRepo->getPendingReports();
    }

    public function getUserReports($userId)
    {
        return $this->reportRepo->getUserReports($userId);
    }

    public function getReport($reportId)
    {
        return $this->reportRepo->getReportById($reportId);
    }

    public function getReportableReports(array $reportableType, $reportableId)
    {
        return $this->reportRepo->getReportsByReportable($reportableType, $reportableId);
    }
}
