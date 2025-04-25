<?php

namespace App\Services\Interfaces;

use App\Models\Report;
use Illuminate\Support\Collection;

interface ReportServiceInterface
{
    /**
     * Get all reports
     * @return Collection
     */
    public function getAllReports(): Collection;
    
    /**
     * Get report by ID
     * @param int $id
     * @return Report
     */
    public function getReportById(int $id): Report;
    
    /**
     * Create new report
     * @param array $data
     * @return Report
     */
    public function createReport(array $data): Report;
    
    /**
     * Update report
     * @param int $id
     * @param array $data
     * @return Report
     */
    public function updateReport(int $id, array $data): Report;
    
    /**
     * Delete report
     * @param int $id
     * @return bool
     */
    public function deleteReport(int $id): bool;
    
    /**
     * Get reports by user
     * @param int $userId
     * @return Collection
     */
    public function getReportsByUser(int $userId): Collection;
    
    /**
     * Get reports by type
     * @param int $typeId
     * @return Collection
     */
    public function getReportsByType(int $typeId): Collection;
    
    /**
     * Get reports for a post
     * @param int $postId
     * @return Collection
     */
    public function getReportsForPost(int $postId): Collection;
    
    /**
     * Get reports for a comment
     * @param int $commentId
     * @return Collection
     */
    public function getReportsForComment(int $commentId): Collection;
    
    /**
     * Handle report
     * @param int $reportId
     * @param string $action
     * @return bool
     */
    public function handleReport(int $reportId, string $action): bool;
}
