<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Support\Collection;

class ReportService implements ReportServiceInterface
{
    /**
     * @var ReportRepositoryInterface
     */
    protected $reportRepository;
    
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;
    
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * ReportService constructor.
     * @param ReportRepositoryInterface $reportRepository
     * @param PostRepositoryInterface $postRepository
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        ReportRepositoryInterface $reportRepository,
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->reportRepository = $reportRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Get all reports
     * @return Collection
     */
    public function getAllReports(): Collection
    {
        return collect($this->reportRepository->all());
    }

    /**
     * Get report by ID
     * @param int $id
     * @return Report
     */
    public function getReportById(int $id): Report
    {
        return $this->reportRepository->find($id);
    }

    /**
     * Create new report
     * @param array $data
     * @return Report
     */
    public function createReport(array $data): Report
    {
        // Set default date if not provided
        if (!isset($data['date'])) {
            $data['date'] = now();
        }
        
        return $this->reportRepository->create($data);
    }

    /**
     * Update report
     * @param int $id
     * @param array $data
     * @return Report
     */
    public function updateReport(int $id, array $data): Report
    {
        return $this->reportRepository->update($id, $data);
    }

    /**
     * Delete report
     * @param int $id
     * @return bool
     */
    public function deleteReport(int $id): bool
    {
        return $this->reportRepository->delete($id);
    }

    /**
     * Get reports by user
     * @param int $userId
     * @return Collection
     */
    public function getReportsByUser(int $userId): Collection
    {
        return collect($this->reportRepository->getByUser($userId));
    }

    /**
     * Get reports by type
     * @param int $typeId
     * @return Collection
     */
    public function getReportsByType(int $typeId): Collection
    {
        return collect($this->reportRepository->getByType($typeId));
    }

    /**
     * Get reports for a post
     * @param int $postId
     * @return Collection
     */
    public function getReportsForPost(int $postId): Collection
    {
        return collect($this->reportRepository->getForPost($postId));
    }

    /**
     * Get reports for a comment
     * @param int $commentId
     * @return Collection
     */
    public function getReportsForComment(int $commentId): Collection
    {
        return collect($this->reportRepository->getForComment($commentId));
    }

    /**
     * Handle report
     * @param int $reportId
     * @param string $action
     * @return bool
     */
    public function handleReport(int $reportId, string $action): bool
    {
        $report = $this->getReportById($reportId);
        
        switch ($action) {
            case 'ignore':
                // Just delete the report
                return $this->deleteReport($reportId);
                
            case 'delete_content':
                // Delete the reported content
                if ($report->reportable_type === Post::class) {
                    $this->postRepository->delete($report->reportable_id);
                } elseif ($report->reportable_type === Comment::class) {
                    $this->commentRepository->delete($report->reportable_id);
                }
                
                // Delete the report
                return $this->deleteReport($reportId);
                
            default:
                return false;
        }
    }
}
