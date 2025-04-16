<?php

namespace App\Repositories;

use App\Models\ReportType;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;

class ReportTypeRepository extends BaseRepository implements ReportTypeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(ReportType $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
