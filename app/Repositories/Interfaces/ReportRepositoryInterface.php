<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface extends RepositoryInterface
{
    public function findByUser($userId);
    public function findByStatus($status);
    public function findByReportType($reportTypeId);
    public function findByReportable($reportableType, $reportableId);
}
