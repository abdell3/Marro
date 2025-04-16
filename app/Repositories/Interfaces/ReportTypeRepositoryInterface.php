<?php

namespace App\Repositories\Interfaces;

interface ReportTypeRepositoryInterface extends RepositoryInterface
{
    public function findByName($name);
}
