<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }

    function createReport(array $data)
    {
        $report = Report::create([
            'reason' => $data['reason'],
            'description' => $data['description'] ?? null,
            'user_id' => $data['user_id'],
            'reportable_type' => $data['reportable_type'],
            'reportable_id' => $data['reportable_id'],
        ]);

        if (isset($data['types'])) {
            $report->types()->sync($data['types']);
        }

        return $report;
    }
    function getPendingReports()
    {
        return Report::pending()->with(['user', 'reportable', 'types'])->latest()->get();
    }
    function getReportById($reportId)
    {
        return Report::with(['user', 'reportable', 'types', 'handler'])->findOrFail($reportId);
    }
    function getReportsByReportable($reportableType, $reportableId)
    {
        return Report::where('reportable_type', $reportableType)
            ->where('reportable_id', $reportableId)
            ->with(['user', 'types'])
            ->latest()
            ->get();
    }
    function getUserReports($userId)
    {
        return Report::where('user_id', $userId)->with(['reportable', 'types'])->latest()->get();
    }
    function updateReportStatus($reportId, $status, $handlerId)
    {
        $report = Report::findOrFail($reportId);
        
        $report->update([
            'status' => $status,
            'handled_by' => $handlerId,
            'handled_at' => now(),
        ]);

        return $report;
    }


}
