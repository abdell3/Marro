<?php

namespace App\Services;

use App\Repositories\Interfaces\ReportTypeRepositoryInterface;

class ReportTypeService
{
    /**
     * Create a new class instance.
     */
    protected $reportTypeRepository;

    public function __construct(ReportTypeRepositoryInterface $reportTypeRepository)
    {
        $this->reportTypeRepository = $reportTypeRepository;
    }

    public function getAllReportTypes()
    {
        return $this->reportTypeRepository->all();
    }

    public function getReportTypeById($id)
    {
        return $this->reportTypeRepository->find($id);
    }

    public function getReportTypeByName($name)
    {
        return $this->reportTypeRepository->findByName($name);
    }

    public function createReportType(array $data)
    {
        return $this->reportTypeRepository->create($data);
    }

    public function updateReportType($id, array $data)
    {
        return $this->reportTypeRepository->update($id, $data);
    }

    public function deleteReportType($id)
    {
        return $this->reportTypeRepository->delete($id);
    }
}
