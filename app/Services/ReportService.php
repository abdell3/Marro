<?php

namespace App\Services;

use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\ReportRepository;
use Illuminate\Support\Facades\Auth;

class ReportService
{
    /**
     * Create a new class instance.
     */


     protected $reportRepository;

     public function __construct(ReportRepositoryInterface $reportRepository)
     {
         $this->reportRepository = $reportRepository;
     }
 
     public function getAllReports()
     {
         return $this->reportRepository->paginate(15);
     }
 
     public function getReportById($id)
     {
         return $this->reportRepository->find($id);
     }
 
     public function getReportsByUser($userId = null)
     {
         $userId = $userId ?? Auth::id();
         return $this->reportRepository->findByUser($userId);
     }
 
     public function getReportsByStatus($status)
     {
         return $this->reportRepository->findByStatus($status);
     }
 
     public function getReportsByType($reportTypeId)
     {
         return $this->reportRepository->findByReportType($reportTypeId);
     }
 
     public function getReportsByReportable($reportableType, $reportableId)
     {
         return $this->reportRepository->findByReportable($reportableType, $reportableId);
     }
 
     public function createReport(array $data)
     {
         $data['user_id'] = $data['user_id'] ?? Auth::id();
         $data['status'] = $data['status'] ?? 'pending';
         
         return $this->reportRepository->create($data);
     }
 
     public function updateReport($id, array $data)
     {
         return $this->reportRepository->update($id, $data);
     }
 
     public function updateReportStatus($id, $status)
     {
         return $this->reportRepository->update($id, ['status' => $status]);
     }
 
     public function deleteReport($id)
     {
         return $this->reportRepository->delete($id);
     }
}
