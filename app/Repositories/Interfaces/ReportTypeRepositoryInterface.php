<?php

namespace App\Repositories\Interfaces;

interface ReportTypeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find report type by name
     * @param string $type
     * @return mixed
     */
    public function findByType(string $type);
}
