<?php

namespace App\Repositories;

use App\Models\ReportType;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;

class ReportTypeRepository extends BaseRepository implements ReportTypeRepositoryInterface
{
    /**
     * ReportTypeRepository constructor.
     * @param ReportType $model
     */
    public function __construct(ReportType $model)
    {
        parent::__construct($model);
    }

    /**
     * Find report type by name
     * @param string $type
     * @return mixed
     */
    public function findByType(string $type)
    {
        return $this->model->where('type', $type)->first();
    }
}
