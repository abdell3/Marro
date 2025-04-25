<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    /**
     * ReportRepository constructor.
     * @param Report $model
     */
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }

    /**
     * Get reports by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('utilisateur_id', $userId)->get();
    }

    /**
     * Get reports by type
     * @param int $typeId
     * @return mixed
     */
    public function getByType(int $typeId)
    {
        return $this->model->where('type_report_id', $typeId)->get();
    }

    /**
     * Get reports for a post
     * @param int $postId
     * @return mixed
     */
    public function getForPost(int $postId)
    {
        return $this->model->where('reportable_type', 'App\\Models\\Post')
            ->where('reportable_id', $postId)
            ->get();
    }

    /**
     * Get reports for a comment
     * @param int $commentId
     * @return mixed
     */
    public function getForComment(int $commentId)
    {
        return $this->model->where('reportable_type', 'App\\Models\\Comment')
            ->where('reportable_id', $commentId)
            ->get();
    }
}
