<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }

    public function findByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findByStatus($status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findByReportType($reportTypeId)
    {
        return $this->model->where('report_type_id', $reportTypeId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findByReportable($reportableType, $reportableId)
    {
        return $this->model->where('reportable_type', $reportableType)
            ->where('reportable_id', $reportableId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
